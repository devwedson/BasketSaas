<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCreateViewsTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_create_pages_render(): void
    {
        $user = User::factory()->create([
            'role' => UserRole::SuperAdmin,
            'email_verified_at' => now(),
        ]);

        $routes = [
            'clubs.create',
            'teams.create',
            'players.create',
            'staff.create',
            'trainings.create',
            'games.create',
            'sponsors.create',
        ];

        foreach ($routes as $route) {
            $this->actingAs($user)->get(route($route))->assertOk();
        }
    }
}