<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Club;
use App\Models\Player;
use App\Models\Setting;
use App\Models\Team;
use App\Models\User;
use App\Services\LandingSettingsService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LandingSettingsTest extends TestCase
{
    use RefreshDatabase;

    private User $superAdmin;

    private Club $club;

    protected function setUp(): void
    {
        parent::setUp();

        $this->club = Club::query()->create([
            'name' => 'Clube CMS',
            'slug' => 'clube-cms',
            'is_active' => true,
        ]);

        $team = Team::query()->create([
            'club_id' => $this->club->id,
            'name' => 'Sub-18',
            'is_active' => true,
        ]);

        Player::query()->create([
            'club_id' => $this->club->id,
            'team_id' => $team->id,
            'name' => 'Atleta CMS',
            'is_active' => true,
        ]);

        $this->superAdmin = User::factory()->create([
            'role' => UserRole::SuperAdmin,
            'email_verified_at' => now(),
        ]);
    }

    public function test_landing_settings_page_renders_for_super_admin(): void
    {
        $this->actingAs($this->superAdmin)
            ->get(route('landing.settings.edit'))
            ->assertOk()
            ->assertSee('Configurações da Landing')
            ->assertSee('Hero (topo da home)');
    }

    public function test_custom_hero_title_appears_on_homepage(): void
    {
        Setting::query()->create([
            'key' => 'landing.featured_club_slug',
            'value' => 'clube-cms',
        ]);

        Setting::query()->create([
            'key' => 'landing.sections',
            'value' => json_encode([
                'hero' => ['title' => 'Título personalizado do hero CMS'],
            ], JSON_UNESCAPED_UNICODE),
        ]);

        app(LandingSettingsService::class)->applyToConfig();

        $this->get(route('landing'))
            ->assertOk()
            ->assertSee('Título personalizado do hero CMS', false);
    }

    public function test_placeholders_are_replaced_in_section_text(): void
    {
        Setting::query()->create([
            'key' => 'landing.featured_club_slug',
            'value' => 'clube-cms',
        ]);

        Setting::query()->create([
            'key' => 'landing.sections',
            'value' => json_encode([
                'home_about' => ['trusted_text' => 'Confiado por {players}+ atletas do {club}'],
            ], JSON_UNESCAPED_UNICODE),
        ]);

        app(LandingSettingsService::class)->applyToConfig();

        $this->get(route('landing'))
            ->assertOk()
            ->assertSee('Confiado por 1+ atletas do Clube CMS', false);
    }

    public function test_super_admin_can_save_landing_sections(): void
    {
        $payload = [
            'brand_name' => 'Basket CMS',
            'brand_tagline' => 'Tagline CMS',
            'sections' => [
                'hero' => [
                    'title' => 'Novo título salvo via formulário',
                ],
            ],
            'testimonials' => [
                ['quote' => 'Depoimento editável no painel.'],
            ],
        ];

        $this->actingAs($this->superAdmin)
            ->put(route('landing.settings.update'), $payload)
            ->assertRedirect(route('landing.settings.edit'));

        $stored = Setting::query()->where('key', 'landing.sections')->value('value');
        $decoded = json_decode($stored, true);

        $this->assertSame('Novo título salvo via formulário', $decoded['hero']['title']);

        $testimonials = json_decode(
            Setting::query()->where('key', 'landing.testimonials')->value('value'),
            true
        );

        $this->assertSame('Depoimento editável no painel.', $testimonials[0]['quote']);
    }
}