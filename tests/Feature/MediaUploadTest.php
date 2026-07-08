<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Setting;
use App\Models\User;
use App\Services\UploadStorageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_panel_upload_path_is_recognized_without_existing_file(): void
    {
        $this->assertTrue(is_custom_media_path('clubs/logos/logo.png'));
        $this->assertFalse(is_custom_media_path('images/logo.svg'));
    }

    public function test_public_upload_url_uses_media_route(): void
    {
        $url = public_upload_url('clubs/logos/logo.png');

        $this->assertStringContainsString('/midia/clubs/logos/logo.png', $url);
    }

    public function test_public_disk_stores_files_under_public_storage(): void
    {
        Storage::fake('public');

        $path = UploadedFile::fake()->image('logo.png')->store('clubs/logos', 'public');

        Storage::disk('public')->assertExists($path);
        $this->assertStringStartsWith('clubs/logos/', $path);
    }

    public function test_storage_fallback_route_serves_legacy_uploads(): void
    {
        $legacyDir = storage_path('app/public/clubs/logos');
        if (! is_dir($legacyDir)) {
            mkdir($legacyDir, 0755, true);
        }

        $legacyFile = $legacyDir.'/legacy.png';
        file_put_contents($legacyFile, 'legacy-logo');

        $this->get('/midia/clubs/logos/legacy.png')
            ->assertOk();

        $this->get('/storage/clubs/logos/legacy.png')
            ->assertOk();

        @unlink($legacyFile);
    }

    public function test_upload_service_removes_storage_junction_before_publishing(): void
    {
        $legacyDir = storage_path('app/public/landing/brand');
        mkdir($legacyDir, 0755, true);
        file_put_contents($legacyDir.'/logo.png', 'logo');

        $uploads = app(UploadStorageService::class);

        if ($uploads->usesStorageJunction()) {
            $uploads->ensureUploadRoot();
            $this->assertFalse($uploads->usesStorageJunction());
        }

        $copied = $uploads->publishLegacyUploads(force: true);

        $this->assertGreaterThanOrEqual(1, $copied);
        $this->assertFileExists(public_path('storage/landing/brand/logo.png'));

        @unlink(public_path('storage/landing/brand/logo.png'));
        @unlink($legacyDir.'/logo.png');
    }

    public function test_upload_service_publishes_legacy_files(): void
    {
        $legacyDir = storage_path('app/public/clubs/logos');
        mkdir($legacyDir, 0755, true);
        file_put_contents($legacyDir.'/legacy.png', 'legacy-logo');

        $copied = app(UploadStorageService::class)->publishLegacyUploads();

        $this->assertSame(1, $copied);
        $this->assertFileExists(public_path('storage/clubs/logos/legacy.png'));
        $this->assertSame('1', Setting::query()->where('key', UploadStorageService::LEGACY_PUBLISHED_KEY)->value('value'));

        @unlink(public_path('storage/clubs/logos/legacy.png'));
        @unlink($legacyDir.'/legacy.png');
    }

    public function test_super_admin_can_repair_uploads_from_panel(): void
    {
        $admin = User::factory()->create([
            'role' => UserRole::SuperAdmin,
            'email_verified_at' => now(),
        ]);

        $this->actingAs($admin)
            ->post(route('system.maintenance.uploads'))
            ->assertRedirect()
            ->assertSessionHas('success');
    }
}