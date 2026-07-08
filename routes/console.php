<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('storage:publish-uploads', function () {
    $legacyRoot = storage_path('app/public');
    $targetRoot = public_path('storage');

    if (! is_dir($targetRoot)) {
        mkdir($targetRoot, 0755, true);
    }

    if (! is_dir($legacyRoot)) {
        $this->info('Nenhum upload legado encontrado.');

        return;
    }

    $files = File::allFiles($legacyRoot);
    $copied = 0;

    foreach ($files as $file) {
        $relativePath = str_replace('\\', '/', substr($file->getPathname(), strlen($legacyRoot) + 1));

        if ($relativePath === '.gitignore' || Storage::disk('public')->exists($relativePath)) {
            continue;
        }

        File::ensureDirectoryExists(dirname($targetRoot.DIRECTORY_SEPARATOR.$relativePath));
        File::copy($file->getPathname(), $targetRoot.DIRECTORY_SEPARATOR.$relativePath);
        $copied++;
    }

    $this->info("Uploads publicados em public/storage ({$copied} arquivo(s) copiado(s)).");
})->purpose('Copia uploads legados de storage/app/public para public/storage');
