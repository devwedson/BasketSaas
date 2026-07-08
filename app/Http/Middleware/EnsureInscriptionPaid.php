<?php

namespace App\Http\Middleware;

use App\Services\StaffInscriptionService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureInscriptionPaid
{
    public function __construct(private StaffInscriptionService $inscriptions) {}

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || $this->inscriptions->hasPaidInscription($user)) {
            return $next($request);
        }

        if ($request->routeIs(
            'inscription.*',
            'webhooks.*',
            'logout',
            'verification.*'
        )) {
            return $next($request);
        }

        return redirect()
            ->route('inscription.checkout')
            ->with('warning', 'Conclua o pagamento da inscrição para acessar o painel.');
    }
}