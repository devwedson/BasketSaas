<?php

namespace App\Http\Controllers;

use App\Services\MercadoPagoService;
use App\Services\StaffInscriptionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InscriptionPaymentController extends Controller
{
    public function __construct(
        private StaffInscriptionService $inscriptions,
        private MercadoPagoService $mercadoPago,
    ) {}

    public function checkout(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($this->inscriptions->hasPaidInscription($user)) {
            return redirect()->route('dashboard')->with('success', 'Sua inscrição já está paga.');
        }

        $payment = $this->inscriptions->pendingPaymentForUser($user);

        if (! $payment) {
            return redirect()
                ->route('dashboard')
                ->with('warning', 'Nenhuma cobrança de inscrição pendente foi encontrada para sua conta.');
        }

        if (! $this->mercadoPago->isReady()) {
            return view('inscription.checkout', [
                'payment' => $payment,
                'checkoutUrl' => null,
                'mercadoPagoReady' => false,
            ]);
        }

        $checkoutUrl = $this->inscriptions->checkoutUrl($payment);

        return view('inscription.checkout', [
            'payment' => $payment->fresh(),
            'checkoutUrl' => $checkoutUrl,
            'mercadoPagoReady' => true,
        ]);
    }

    public function success(Request $request): RedirectResponse
    {
        return redirect()
            ->route('inscription.checkout')
            ->with('success', 'Pagamento recebido! Estamos confirmando com o Mercado Pago. Aguarde alguns instantes.');
    }

    public function failure(): RedirectResponse
    {
        return redirect()
            ->route('inscription.checkout')
            ->withErrors(['payment' => 'Pagamento não concluído. Tente novamente.']);
    }

    public function pending(): RedirectResponse
    {
        return redirect()
            ->route('inscription.checkout')
            ->with('warning', 'Pagamento pendente de confirmação. Você será liberado assim que for aprovado.');
    }
}