<?php

use App\Services\UploadStorageService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('storage:publish-uploads', function (UploadStorageService $uploads) {
    $copied = $uploads->publishLegacyUploads();

    $this->info("Uploads publicados em public/storage ({$copied} arquivo(s) copiado(s)).");
})->purpose('Copia uploads legados de storage/app/public para public/storage');
