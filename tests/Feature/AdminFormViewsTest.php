<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Club;
use App\Models\Game;
use App\Models\Player;
use App\Models\Season;
use App\Models\Sponsor;
use App\Models\Staff;
use App\Models\Team;
use App\Models\Training;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminFormViewsTest extends TestCase
{
    use RefreshDatabase;

    private Club $club;

    private User $superAdmin;

    private User $clubUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->club = Club::query()->create([
            'name' => 'Clube Teste',
            'slug' => 'clube-teste',
            'is_active' => true,
        ]);

        $season = Season::query()->create([
            'club_id' => $this->club->id,
            'name' => '2026',
            'is_current' => true,
            'start_date' => now()->startOfYear(),
            'end_date' => now()->endOfYear(),
        ]);

        Team::query()->create([
            'club_id' => $this->club->id,
            'season_id' => $season->id,
            'name' => 'Sub-16',
            'is_active' => true,
        ]);

        $this->superAdmin = User::factory()->create([
            'role' => UserRole::SuperAdmin,
            'email_verified_at' => now(),
        ]);

        $this->clubUser = User::factory()->create([
            'role' => UserRole::Club,
            'club_id' => $this->club->id,
            'email_verified_at' => now(),
        ]);
    }

    public function test_super_admin_create_pages_render(): void
    {
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
            $this->actingAs($this->superAdmin)->get(route($route))->assertOk();
        }
    }

    public function test_club_user_create_pages_render(): void
    {
        $routes = [
            'teams.create',
            'players.create',
            'staff.create',
            'trainings.create',
            'games.create',
            'sponsors.create',
        ];

        foreach ($routes as $route) {
            $this->actingAs($this->clubUser)->get(route($route))->assertOk();
        }
    }

    public function test_club_user_edit_pages_render(): void
    {
        $team = Team::query()->where('club_id', $this->club->id)->firstOrFail();
        $player = Player::query()->create([
            'club_id' => $this->club->id,
            'team_id' => $team->id,
            'name' => 'Jogador Teste',
            'is_active' => true,
        ]);
        $staff = Staff::query()->create([
            'club_id' => $this->club->id,
            'team_id' => $team->id,
            'name' => 'Técnico Teste',
            'role' => 'coach',
            'is_active' => true,
        ]);
        $training = Training::query()->create([
            'club_id' => $this->club->id,
            'team_id' => $team->id,
            'title' => 'Treino Teste',
            'scheduled_at' => now()->addDay(),
        ]);
        $game = Game::query()->create([
            'club_id' => $this->club->id,
            'team_id' => $team->id,
            'opponent' => 'Rivals BC',
            'scheduled_at' => now()->addDays(2),
            'is_home' => true,
        ]);
        $sponsor = Sponsor::query()->create([
            'club_id' => $this->club->id,
            'name' => 'Patrocinador Teste',
            'tier' => 'gold',
            'is_active' => true,
            'show_on_landing' => true,
        ]);

        $routes = [
            ['teams.edit', $team],
            ['players.edit', $player],
            ['staff.edit', $staff],
            ['trainings.edit', $training],
            ['games.edit', $game],
            ['sponsors.edit', $sponsor],
        ];

        foreach ($routes as [$route, $model]) {
            $this->actingAs($this->clubUser)->get(route($route, $model))->assertOk();
        }
    }
}