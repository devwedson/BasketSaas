<?php

namespace App\Services;

use App\Models\InscriptionPayment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class InscriptionReceiptService
{
    public function __construct(private PaymentSettingsService $paymentSettings) {}

    public function ensure(InscriptionPayment $payment): InscriptionPayment
    {
        if (! $payment->isPaid()) {
            return $payment;
        }

        if (filled($payment->receipt_path) && Storage::disk('public')->exists($payment->receipt_path)) {
            return $payment;
        }

        return $this->generate($payment);
    }

    public function generate(InscriptionPayment $payment): InscriptionPayment
    {
        abort_unless($payment->isPaid(), 422, 'Comprovante disponível apenas para pagamentos aprovados.');

        $payment->loadMissing(['club', 'staff', 'user']);

        $pdf = Pdf::loadView('inscription.receipt-pdf', [
            'payment' => $payment,
            'receiptNumber' => $this->receiptNumber($payment),
            'description' => $this->paymentSettings->all()['inscription_description'],
        ])->setPaper('a4', 'portrait');

        $path = "inscription-receipts/{$payment->id}/comprovante.pdf";

        Storage::disk('public')->put($path, $pdf->output());

        $payment->update(['receipt_path' => $path]);

        return $payment->fresh();
    }

    public function receiptNumber(InscriptionPayment $payment): string
    {
        $year = $payment->paid_at?->format('Y') ?? $payment->created_at->format('Y');

        return sprintf('INS-%s-%05d', $year, $payment->id);
    }
}