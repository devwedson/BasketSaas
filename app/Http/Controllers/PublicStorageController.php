<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PublicStorageController extends Controller
{
    public function show(string $path): BinaryFileResponse|Response
    {
        $path = ltrim(str_replace('\\', '/', $path), '/');

        abort_if($path === '' || str_contains($path, '..'), 404);

        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->response($path);
        }

        $legacyPath = storage_path('app/public/'.$path);

        if (is_file($legacyPath)) {
            return response()->file($legacyPath);
        }

        abort(404);
    }
}