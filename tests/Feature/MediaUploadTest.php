<?php

namespace Tests\Feature;

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

        $this->get('/storage/clubs/logos/legacy.png')
            ->assertOk();

        @unlink($legacyFile);
    }
}