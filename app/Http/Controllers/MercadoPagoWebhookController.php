<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatus;
use App\Models\InscriptionPayment;
use App\Services\MercadoPagoService;
use App\Services\StaffInscriptionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MercadoPagoWebhookController extends Controller
{
    public function __construct(
        private MercadoPagoService $mercadoPago,
        private StaffInscriptionService $inscriptions,
    ) {}

    public function handle(Request $request): Response
    {
        $paymentId = $request->input('data.id')
            ?? $request->input('id')
            ?? $request->query('id');

        if (! $paymentId || ! $this->mercadoPago->isReady()) {
            return response('ignored', 200);
        }

        $mpPayment = $this->mercadoPago->fetchPayment((string) $paymentId);

        if (! $mpPayment) {
            return response('not found', 404);
        }

        $reference = $mpPayment->external_reference ?? null;

        if (! $reference) {
            return response('no reference', 200);
        }

        $payment = InscriptionPayment::query()->find($reference);

        if (! $payment) {
            return response('unknown payment', 200);
        }

        $status = (string) ($mpPayment->status ?? '');

        match ($status) {
            'approved' => $this->inscriptions->markApproved($payment, (string) $mpPayment->id),
            'rejected', 'cancelled' => $this->inscriptions->markRejected(
                $payment,
                $status === 'cancelled' ? PaymentStatus::Cancelled : PaymentStatus::Rejected
            ),
            default => null,
        };

        return response('ok', 200);
    }
}