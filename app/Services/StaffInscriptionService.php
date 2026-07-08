<?php

namespace App\Services;

use App\Enums\PaymentStatus;
use App\Enums\StaffRole;
use App\Enums\UserRole;
use App\Models\FinancialTransaction;
use App\Models\InscriptionPayment;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StaffInscriptionService
{
    public function __construct(
        private PaymentSettingsService $paymentSettings,
        private MercadoPagoService $mercadoPago,
    ) {}

    public function shouldChargeInscription(): bool
    {
        return $this->paymentSettings->inscriptionRequired();
    }

    public function provisionAccess(Staff $staff, bool $forceNewPayment = false): array
    {
        abort_if(blank($staff->email), 422, 'Informe o e-mail para criar acesso ao painel.');

        return DB::transaction(function () use ($staff, $forceNewPayment) {
            [$user, $plainPassword] = $this->resolveUser($staff);
            $staff->update(['user_id' => $user->id]);

            $payment = $this->resolvePayment($staff, $user, $forceNewPayment);

            return [
                'user' => $user,
                'payment' => $payment,
                'plain_password' => $plainPassword,
            ];
        });
    }

    public function checkoutUrl(InscriptionPayment $payment): string
    {
        if ($payment->isExpired() || ($payment->isPending() && blank($payment->preference_id))) {
            $payment = $this->refreshPreference($payment);
        }

        $useSandbox = (bool) config('mercadopago.sandbox', true);

        return $useSandbox
            ? ($payment->metadata['sandbox_init_point'] ?? $payment->metadata['init_point'])
            : ($payment->metadata['init_point'] ?? $payment->metadata['sandbox_init_point']);
    }

    public function refreshPreference(InscriptionPayment $payment): InscriptionPayment
    {
        if ($payment->isPaid() || ! $this->mercadoPago->isReady()) {
            return $payment;
        }

        try {
            $preference = $this->mercadoPago->createPreference($payment);

            $payment->update([
                'status' => PaymentStatus::Pending,
                'preference_id' => $preference['preference_id'],
                'expires_at' => now()->addHours(config('payment.preference_expiration_hours', 48)),
                'metadata' => array_merge($payment->metadata ?? [], $preference),
            ]);
        } catch (\Throwable $exception) {
            report($exception);
        }

        return $payment->fresh();
    }

    public function markApproved(InscriptionPayment $payment, ?string $mercadoPagoPaymentId = null): void
    {
        if ($payment->isPaid()) {
            return;
        }

        DB::transaction(function () use ($payment, $mercadoPagoPaymentId) {
            $payment->update([
                'status' => PaymentStatus::Approved,
                'payment_id' => $mercadoPagoPaymentId,
                'paid_at' => now(),
            ]);

            $payment->user->update(['is_active' => true]);
            $payment->staff->update(['is_active' => true]);

            FinancialTransaction::query()->updateOrCreate(
                ['inscription_payment_id' => $payment->id],
                [
                    'club_id' => $payment->club_id,
                    'staff_id' => $payment->staff_id,
                    'type' => 'income',
                    'category' => 'inscricao',
                    'description' => 'Inscrição: '.$payment->staff->name,
                    'amount' => $payment->amount,
                    'transaction_date' => now()->toDateString(),
                ]
            );
        });
    }

    public function markRejected(InscriptionPayment $payment, PaymentStatus $status = PaymentStatus::Rejected): void
    {
        if ($payment->isPaid()) {
            return;
        }

        $payment->update(['status' => $status]);
    }

    public function pendingPaymentForUser(User $user): ?InscriptionPayment
    {
        if (! $user->hasRole(UserRole::Coach, UserRole::Assistant)) {
            return null;
        }

        return InscriptionPayment::query()
            ->where('user_id', $user->id)
            ->whereIn('status', [PaymentStatus::Pending, PaymentStatus::Rejected])
            ->latest()
            ->first();
    }

    public function hasPaidInscription(User $user): bool
    {
        if (! $user->hasRole(UserRole::Coach, UserRole::Assistant)) {
            return true;
        }

        if (! $this->shouldChargeInscription()) {
            return true;
        }

        return InscriptionPayment::query()
            ->where('user_id', $user->id)
            ->where('status', PaymentStatus::Approved)
            ->exists();
    }

    private function resolveUser(Staff $staff): array
    {
        $existing = User::query()->where('email', $staff->email)->first();

        if ($existing) {
            $existing->update([
                'name' => $staff->name,
                'role' => $this->mapStaffRoleToUserRole($staff->role),
                'club_id' => $staff->club_id,
                'phone' => $staff->phone,
            ]);

            return [$existing, null];
        }

        $password = Str::password(12);

        $user = User::query()->create([
            'name' => $staff->name,
            'email' => $staff->email,
            'password' => $password,
            'role' => $this->mapStaffRoleToUserRole($staff->role),
            'club_id' => $staff->club_id,
            'phone' => $staff->phone,
            'is_active' => ! $this->paymentSettings->inscriptionRequired(),
            'email_verified_at' => now(),
        ]);

        return [$user, $password];
    }

    private function resolvePayment(Staff $staff, User $user, bool $forceNewPayment): InscriptionPayment
    {
        $approved = InscriptionPayment::query()
            ->where('staff_id', $staff->id)
            ->where('status', PaymentStatus::Approved)
            ->first();

        if ($approved) {
            return $approved;
        }

        $pending = InscriptionPayment::query()
            ->where('staff_id', $staff->id)
            ->where('status', PaymentStatus::Pending)
            ->latest()
            ->first();

        if ($pending && ! $forceNewPayment && ! $pending->isExpired()) {
            return $pending;
        }

        if ($pending && $pending->isPending()) {
            $pending->update(['status' => PaymentStatus::Expired]);
        }

        $settings = $this->paymentSettings->all();

        $payment = InscriptionPayment::query()->create([
            'club_id' => $staff->club_id,
            'staff_id' => $staff->id,
            'user_id' => $user->id,
            'amount' => $settings['inscription_amount'],
            'currency' => 'BRL',
            'status' => PaymentStatus::Pending,
            'expires_at' => now()->addHours(config('payment.preference_expiration_hours', 48)),
        ]);

        $user->update(['is_active' => false]);

        if ($this->mercadoPago->isReady()) {
            $this->refreshPreference($payment);
        }

        return $payment->fresh();
    }

    private function mapStaffRoleToUserRole(StaffRole $role): UserRole
    {
        return match ($role) {
            StaffRole::Coach, StaffRole::PhysicalTrainer => UserRole::Coach,
            StaffRole::Assistant, StaffRole::Physiotherapist => UserRole::Assistant,
        };
    }
}