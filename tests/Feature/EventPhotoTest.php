<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Club;
use App\Models\EventPhoto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EventPhotoTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_create_event_photo(): void
    {
        Storage::fake('public');

        $club = Club::query()->create([
            'name' => 'Clube Teste',
            'slug' => 'clube-teste',
            'is_active' => true,
        ]);

        $admin = User::factory()->create([
            'role' => UserRole::SuperAdmin,
            'email_verified_at' => now(),
        ]);

        $this->actingAs($admin)
            ->post(route('event-photos.store'), [
                'club_id' => $club->id,
                'title' => 'Torneio Sub-16',
                'event_date' => '2026-03-15',
                'image' => UploadedFile::fake()->image('evento.jpg'),
                'is_active' => '1',
            ])
            ->assertRedirect(route('event-photos.index'));

        $photo = EventPhoto::query()->first();
        $this->assertNotNull($photo);
        $this->assertSame('Torneio Sub-16', $photo->title);
        Storage::disk('public')->assertExists($photo->image);
    }

    public function test_club_admin_cannot_access_event_photos_panel(): void
    {
        $admin = User::factory()->create([
            'role' => UserRole::Club,
            'email_verified_at' => now(),
        ]);

        $this->actingAs($admin)
            ->get(route('event-photos.index'))
            ->assertForbidden();
    }

    public function test_active_event_photos_appear_on_landing_page(): void
    {
        Storage::fake('public');

        $club = Club::query()->create([
            'name' => 'Clube Teste',
            'slug' => 'clube-exemplo',
            'is_active' => true,
        ]);

        $path = UploadedFile::fake()->image('evento.jpg')->store('events/photos', 'public');

        EventPhoto::query()->create([
            'club_id' => $club->id,
            'title' => 'Festival de Basquete',
            'image' => $path,
            'is_active' => true,
        ]);

        $this->get(route('landing.events'))
            ->assertOk()
            ->assertSee('Festival de Basquete');
    }
}