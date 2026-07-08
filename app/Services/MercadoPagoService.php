<?php

namespace App\Services;

use App\Models\InscriptionPayment;
use MercadoPago\Client\Payment\PaymentClient;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;

class MercadoPagoService
{
    public function __construct(private PaymentSettingsService $settings) {}

    public function isReady(): bool
    {
        return $this->settings->isConfigured();
    }

    public function createPreference(InscriptionPayment $payment): array
    {
        $this->configure();

        $description = config('payment.inscription_description', 'Inscrição');
        $staffName = $payment->staff?->name ?? 'Comissão Técnica';

        $client = new PreferenceClient();

        $preference = $client->create([
            'items' => [
                [
                    'id' => (string) $payment->id,
                    'title' => $description,
                    'description' => "Inscrição de {$staffName}",
                    'quantity' => 1,
                    'currency_id' => 'BRL',
                    'unit_price' => (float) $payment->amount,
                ],
            ],
            'payer' => [
                'email' => $payment->user->email,
                'name' => $payment->user->name,
            ],
            'back_urls' => [
                'success' => route('inscription.success'),
                'failure' => route('inscription.failure'),
                'pending' => route('inscription.pending'),
            ],
            'auto_return' => 'approved',
            'external_reference' => (string) $payment->id,
            'notification_url' => route('webhooks.mercadopago'),
            'expires' => true,
            'expiration_date_to' => now()
                ->addHours(config('payment.preference_expiration_hours', 48))
                ->toIso8601String(),
        ]);

        return [
            'preference_id' => $preference->id,
            'init_point' => $preference->init_point,
            'sandbox_init_point' => $preference->sandbox_init_point ?? $preference->init_point,
        ];
    }

    public function fetchPayment(string $paymentId): ?object
    {
        $this->configure();

        try {
            return (new PaymentClient)->get((int) $paymentId);
        } catch (\Throwable) {
            return null;
        }
    }

    private function configure(): void
    {
        $token = config('mercadopago.access_token');

        abort_if(blank($token), 500, 'Mercado Pago não configurado.');

        MercadoPagoConfig::setAccessToken($token);
    }
}