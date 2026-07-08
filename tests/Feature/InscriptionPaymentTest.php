<?php

namespace Tests\Feature;

use App\Enums\PaymentStatus;
use App\Enums\StaffRole;
use App\Enums\UserRole;
use App\Models\Club;
use App\Models\InscriptionPayment;
use App\Models\Setting;
use App\Models\Staff;
use App\Models\User;
use App\Services\StaffInscriptionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InscriptionPaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_coach_with_pending_inscription_is_redirected_to_checkout(): void
    {
        $club = Club::query()->create([
            'name' => 'Clube Teste',
            'slug' => 'clube-teste',
            'is_active' => true,
        ]);

        $user = User::factory()->create([
            'role' => UserRole::Coach,
            'club_id' => $club->id,
            'is_active' => false,
            'email_verified_at' => now(),
        ]);

        $staff = Staff::query()->create([
            'club_id' => $club->id,
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => StaffRole::Coach,
            'is_active' => true,
        ]);

        $this->seedPaymentSettings();

        InscriptionPayment::query()->create([
            'club_id' => $club->id,
            'staff_id' => $staff->id,
            'user_id' => $user->id,
            'amount' => 150,
            'status' => PaymentStatus::Pending,
        ]);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertRedirect(route('inscription.checkout'));
    }

    public function test_coach_with_approved_inscription_accesses_dashboard(): void
    {
        $club = Club::query()->create([
            'name' => 'Clube Teste',
            'slug' => 'clube-teste',
            'is_active' => true,
        ]);

        $user = User::factory()->create([
            'role' => UserRole::Coach,
            'club_id' => $club->id,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $staff = Staff::query()->create([
            'club_id' => $club->id,
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => StaffRole::Coach,
            'is_active' => true,
        ]);

        $this->seedPaymentSettings();

        InscriptionPayment::query()->create([
            'club_id' => $club->id,
            'staff_id' => $staff->id,
            'user_id' => $user->id,
            'amount' => 150,
            'status' => PaymentStatus::Approved,
            'paid_at' => now(),
        ]);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk();
    }

    public function test_staff_store_can_provision_access_and_payment(): void
    {
        $club = Club::query()->create([
            'name' => 'Clube Teste',
            'slug' => 'clube-teste',
            'is_active' => true,
        ]);

        $admin = User::factory()->create([
            'role' => UserRole::SuperAdmin,
            'email_verified_at' => now(),
        ]);

        $this->seedPaymentSettings();

        $this->actingAs($admin)->post(route('staff.store'), [
            'club_id' => $club->id,
            'name' => 'Novo Técnico',
            'email' => 'tecnico@teste.com',
            'role' => StaffRole::Coach->value,
            'create_panel_access' => '1',
        ])->assertRedirect(route('staff.index'));

        $staff = Staff::query()->where('email', 'tecnico@teste.com')->first();
        $this->assertNotNull($staff);
        $this->assertNotNull($staff->user_id);

        $payment = InscriptionPayment::query()->where('staff_id', $staff->id)->first();
        $this->assertNotNull($payment);
        $this->assertTrue($payment->status === PaymentStatus::Pending);

        $this->assertFalse(app(StaffInscriptionService::class)->hasPaidInscription($staff->user));
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