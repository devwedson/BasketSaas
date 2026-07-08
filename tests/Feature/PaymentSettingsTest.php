<?php

namespace Tests\Feature;

use App\Enums\PaymentStatus;
use App\Enums\UserRole;
use App\Models\Club;
use App\Models\InscriptionPayment;
use App\Models\Setting;
use App\Models\Staff;
use App\Models\User;
use App\Services\StaffInscriptionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaymentSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_brazilian_money_format_is_parsed_on_save(): void
    {
        $admin = User::factory()->create([
            'role' => UserRole::SuperAdmin,
            'email_verified_at' => now(),
        ]);

        $this->seedPaymentSettings();

        $this->actingAs($admin)
            ->put(route('payment.settings.update'), [
                'inscription_enabled' => '1',
                'inscription_amount' => '1.500,50',
                'inscription_description' => 'Inscrição',
            ])
            ->assertRedirect(route('payment.settings.edit'));

        $this->assertSame('1500.5', Setting::query()->where('key', 'payment.inscription_amount')->value('value'));
    }

    public function test_pending_inscription_payments_are_updated_when_amount_changes(): void
    {
        $club = Club::query()->create([
            'name' => 'Clube Teste',
            'slug' => 'clube-teste',
            'is_active' => true,
        ]);

        $user = User::factory()->create([
            'role' => UserRole::Coach,
            'club_id' => $club->id,
            'email_verified_at' => now(),
        ]);

        $staff = Staff::query()->create([
            'club_id' => $club->id,
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => \App\Enums\StaffRole::Coach,
            'is_active' => true,
        ]);

        $this->seedPaymentSettings();

        $payment = InscriptionPayment::query()->create([
            'club_id' => $club->id,
            'staff_id' => $staff->id,
            'user_id' => $user->id,
            'amount' => 150,
            'status' => PaymentStatus::Pending,
        ]);

        Setting::query()->where('key', 'payment.inscription_amount')->update(['value' => '1500.5']);

        $updated = app(StaffInscriptionService::class)->syncPendingAmountsToSettings();

        $this->assertSame(1, $updated);
        $this->assertSame('1500.50', $payment->fresh()->amount);
    }

    private function seedPaymentSettings(): void
    {
        Setting::query()->create(['key' => 'payment.inscription_enabled', 'value' => '1']);
        Setting::query()->create(['key' => 'payment.inscription_amount', 'value' => '150']);
        Setting::query()->create(['key' => 'payment.inscription_description', 'value' => 'Inscrição']);
        Setting::query()->create(['key' => 'mercadopago.access_token', 'value' => 'TEST-token']);
        Setting::query()->create(['key' => 'mercadopago.sandbox', 'value' => '1']);
    }
}