<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UploadStorageService
{
    public const LEGACY_PUBLISHED_KEY = 'storage.legacy_published';

    public function storeUpload(UploadedFile $file, string $directory): string
    {
        $this->ensureUploadRoot();

        return $file->store($directory, 'public');
    }

    public function ensureUploadRoot(): void
    {
        $uploadRoot = public_path('storage');

        if ($this->usesStorageJunction($uploadRoot)) {
            $this->removeStorageJunction($uploadRoot);
        }

        if (! is_dir($uploadRoot)) {
            mkdir($uploadRoot, 0755, true);
        }
    }

    public function usesStorageJunction(?string $uploadRoot = null): bool
    {
        $uploadRoot ??= public_path('storage');

        if (! file_exists($uploadRoot)) {
            return false;
        }

        if (is_link($uploadRoot)) {
            return true;
        }

        $realUpload = realpath($uploadRoot);
        $realLegacy = realpath(storage_path('app/public'));

        return $realUpload && $realLegacy && $realUpload === $realLegacy;
    }

    public function publishLegacyUploads(bool $force = false): int
    {
        $this->ensureUploadRoot();

        if ($force) {
            $this->resetLegacyPublishedFlag();
        }

        $legacyRoot = storage_path('app/public');

        if (! is_dir($legacyRoot)) {
            $this->markLegacyPublished();

            return 0;
        }

        $copied = 0;

        foreach (File::allFiles($legacyRoot) as $file) {
            $relativePath = str_replace('\\', '/', substr($file->getPathname(), strlen($legacyRoot) + 1));

            if ($relativePath === '.gitignore' || is_file(public_path('storage'.DIRECTORY_SEPARATOR.$relativePath))) {
                continue;
            }

            $targetPath = public_path('storage'.DIRECTORY_SEPARATOR.$relativePath);
            File::ensureDirectoryExists(dirname($targetPath));
            File::copy($file->getPathname(), $targetPath);
            $copied++;
        }

        if (! $this->hasUnpublishedLegacyFiles()) {
            $this->markLegacyPublished();
        }

        return $copied;
    }

    public function shouldPublishLegacyUploads(): bool
    {
        return $this->hasUnpublishedLegacyFiles();
    }

    public function hasUnpublishedLegacyFiles(): bool
    {
        if ($this->usesStorageJunction()) {
            return $this->legacyUploadsAvailable();
        }

        $legacyRoot = storage_path('app/public');

        if (! is_dir($legacyRoot)) {
            return false;
        }

        foreach (File::allFiles($legacyRoot) as $file) {
            $relativePath = str_replace('\\', '/', substr($file->getPathname(), strlen($legacyRoot) + 1));

            if ($relativePath === '.gitignore') {
                continue;
            }

            if (! is_file(public_path('storage'.DIRECTORY_SEPARATOR.$relativePath))) {
                return true;
            }
        }

        return false;
    }

    public function absolutePathFor(string $relativePath, bool $preferPublic = false): ?string
    {
        $relativePath = ltrim(str_replace('\\', '/', $relativePath), '/');

        if ($relativePath === '' || str_contains($relativePath, '..')) {
            return null;
        }

        $candidates = $preferPublic
            ? [public_path('storage/'.$relativePath), storage_path('app/public/'.$relativePath)]
            : [storage_path('app/public/'.$relativePath), public_path('storage/'.$relativePath)];

        foreach ($candidates as $candidate) {
            if (is_file($candidate)) {
                return $candidate;
            }
        }

        if (Storage::disk('public')->exists($relativePath)) {
            return Storage::disk('public')->path($relativePath);
        }

        return null;
    }

    public function resetLegacyPublishedFlag(): void
    {
        Setting::query()->where('key', self::LEGACY_PUBLISHED_KEY)->delete();
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

        return is_writable(public_path('storage')) && ! $this->usesStorageJunction();
    }

    private function removeStorageJunction(string $path): void
    {
        if (is_link($path)) {
            unlink($path);

            return;
        }

        // Junction no Windows: remove só o atalho, mantém storage/app/public intacto.
        @rmdir($path);
    }

    private function markLegacyPublished(): void
    {
        Setting::query()->updateOrCreate(
            ['key' => self::LEGACY_PUBLISHED_KEY],
            ['value' => '1']
        );
    }
}