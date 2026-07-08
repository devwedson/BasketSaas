<?php

namespace App\Http\Controllers;

use App\Services\UploadStorageService;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PublicStorageController extends Controller
{
    public function show(string $path, UploadStorageService $uploads): BinaryFileResponse
    {
        $absolutePath = $uploads->absolutePathFor($path);

        abort_if($absolutePath === null, 404);

        return response()->file($absolutePath);
    }
}