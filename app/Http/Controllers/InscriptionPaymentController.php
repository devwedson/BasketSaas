<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Controllers\Concerns\ScopesByClub;
use App\Models\InscriptionPayment;
use App\Services\InscriptionReceiptService;
use App\Services\MercadoPagoService;
use App\Services\StaffInscriptionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InscriptionPaymentController extends Controller
{
    use ScopesByClub;

    public function __construct(
        private StaffInscriptionService $inscriptions,
        private MercadoPagoService $mercadoPago,
        private InscriptionReceiptService $receipts,
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
            ->route('dashboard')
            ->with('success', 'Pagamento recebido! Estamos confirmando com o Mercado Pago. O comprovante ficará disponível no painel assim que for aprovado.');
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

    public function latestReceipt(Request $request): StreamedResponse
    {
        $payment = $this->inscriptions->approvedPaymentForUser($request->user());

        abort_if(! $payment, 404, 'Nenhum pagamento aprovado encontrado.');

        return $this->streamReceipt($payment);
    }

    public function showReceipt(Request $request, InscriptionPayment $payment): StreamedResponse
    {
        $this->authorizeReceipt($request, $payment);

        return $this->streamReceipt($payment);
    }

    private function streamReceipt(InscriptionPayment $payment): StreamedResponse
    {
        $payment = $this->receipts->ensure($payment);

        abort_unless($payment->hasReceipt() && Storage::disk('public')->exists($payment->receipt_path), 404);

        $filename = 'comprovante-inscricao-'.$payment->id.'.pdf';

        return Storage::disk('public')->response($payment->receipt_path, $filename, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$filename.'"',
        ]);
    }

    private function authorizeReceipt(Request $request, InscriptionPayment $payment): void
    {
        $user = $request->user();

        if ($payment->user_id === $user->id) {
            return;
        }

        if ($user->hasRole(UserRole::SuperAdmin, UserRole::Club)) {
            $this->authorizeClubAccess($request, $payment->club_id);

            return;
        }

        abort(403);
    }
}