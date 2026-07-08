<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UploadStorageService
{
    public const LEGACY_PUBLISHED_KEY = 'storage.legacy_published';

    public function ensureUploadRoot(): void
    {
        $uploadRoot = public_path('storage');

        if (! is_dir($uploadRoot)) {
            mkdir($uploadRoot, 0755, true);
        }
    }

    public function publishLegacyUploads(): int
    {
        $this->ensureUploadRoot();

        $legacyRoot = storage_path('app/public');

        if (! is_dir($legacyRoot)) {
            $this->markLegacyPublished();

            return 0;
        }

        $copied = 0;

        foreach (File::allFiles($legacyRoot) as $file) {
            $relativePath = str_replace('\\', '/', substr($file->getPathname(), strlen($legacyRoot) + 1));

            if ($relativePath === '.gitignore' || Storage::disk('public')->exists($relativePath)) {
                continue;
            }

            $targetPath = public_path('storage'.DIRECTORY_SEPARATOR.$relativePath);
            File::ensureDirectoryExists(dirname($targetPath));
            File::copy($file->getPathname(), $targetPath);
            $copied++;
        }

        $this->markLegacyPublished();

        return $copied;
    }

    public function shouldPublishLegacyUploads(): bool
    {
        if (! $this->legacyUploadsAvailable()) {
            return false;
        }

        return Setting::query()
            ->where('key', self::LEGACY_PUBLISHED_KEY)
            ->value('value') !== '1';
    }

    public function legacyUploadsAvailable(): bool
    {
        $legacyRoot = storage_path('app/public');

        if (! is_dir($legacyRoot)) {
            return false;
        }

        foreach (File::allFiles($legacyRoot) as $file) {
            $relativePath = str_replace('\\', '/', substr($file->getPathname(), strlen($legacyRoot) + 1));

            if ($relativePath !== '.gitignore') {
                return true;
            }
        }

        return false;
    }

    public function uploadRootWritable(): bool
    {
        $this->ensureUploadRoot();

        return is_writable(public_path('storage'));
    }

    private function markLegacyPublished(): void
    {
        Setting::query()->updateOrCreate(
            ['key' => self::LEGACY_PUBLISHED_KEY],
            ['value' => '1']
        );
    }
}