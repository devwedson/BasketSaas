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
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_unverified_user_is_redirected_to_email_activation_page(): void
    {
        User::factory()->create([
            'email' => 'pendente@teste.com',
            'password' => 'password',
            'is_active' => true,
            'email_verified_at' => null,
        ]);

        $this->post(route('login'), [
            'email' => 'pendente@teste.com',
            'password' => 'password',
        ])
            ->assertRedirect(route('verification.notice'));

        $this->assertAuthenticated();
    }

    public function test_inactive_unverified_user_is_redirected_to_email_activation_page(): void
    {
        User::factory()->create([
            'email' => 'staff@teste.com',
            'password' => 'password',
            'is_active' => false,
            'email_verified_at' => null,
        ]);

        $this->post(route('login'), [
            'email' => 'staff@teste.com',
            'password' => 'password',
        ])
            ->assertRedirect(route('verification.notice'));

        $this->assertAuthenticated();
    }

    public function test_inactive_verified_user_with_pending_inscription_is_redirected_to_checkout(): void
    {
        $club = Club::query()->create([
            'name' => 'Clube Teste',
            'slug' => 'clube-teste',
            'is_active' => true,
        ]);

        $user = User::factory()->create([
            'role' => UserRole::Coach,
            'club_id' => $club->id,
            'email' => 'tecnico@teste.com',
            'password' => 'password',
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

        $this->post(route('login'), [
            'email' => 'tecnico@teste.com',
            'password' => 'password',
        ])
            ->assertRedirect(route('inscription.checkout'));

        $this->assertAuthenticated();
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