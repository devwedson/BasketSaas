<?php

namespace App\Http\Controllers;

use App\Services\UploadStorageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;

class SystemMaintenanceController extends Controller
{
    public function repairUploads(UploadStorageService $uploads): RedirectResponse
    {
        $uploads->ensureUploadRoot();
        $copied = $uploads->publishLegacyUploads();

        try {
            Artisan::call('config:clear');
            Artisan::call('view:clear');
        } catch (\Throwable) {
            // Hospedagens restritas podem bloquear alguns comandos; uploads seguem valendo.
        }

        $message = $copied > 0
            ? "Uploads reparados com sucesso ({$copied} arquivo(s) publicado(s))."
            : 'Pasta de uploads verificada. Novos envios já ficam acessíveis em public/storage.';

        if (! $uploads->uploadRootWritable()) {
            $message .= ' Atenção: a pasta public/storage não tem permissão de escrita — ajuste no painel da hospedagem (755 ou 775).';
        }

        return back()->with('success', $message);
    }
}