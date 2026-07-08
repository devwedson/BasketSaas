<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Crypt;

class PaymentSettingsService
{
    public const KEYS = [
        'payment.inscription_enabled',
        'payment.inscription_amount',
        'payment.inscription_description',
        'mercadopago.public_key',
        'mercadopago.access_token',
        'mercadopago.sandbox',
    ];

    public function all(): array
    {
        $stored = Setting::query()
            ->whereIn('key', self::KEYS)
            ->pluck('value', 'key');

        return [
            'inscription_enabled' => filter_var(
                $stored->get('payment.inscription_enabled', config('payment.inscription_enabled', true)),
                FILTER_VALIDATE_BOOLEAN
            ),
            'inscription_amount' => (float) ($stored->get('payment.inscription_amount') ?: config('payment.inscription_amount', 150)),
            'inscription_description' => (string) ($stored->get('payment.inscription_description') ?: config('payment.inscription_description', 'Inscrição — Comissão Técnica')),
            'public_key' => (string) ($stored->get('mercadopago.public_key') ?: config('mercadopago.public_key', '')),
            'access_token' => $this->decryptToken($stored->get('mercadopago.access_token')),
            'sandbox' => filter_var(
                $stored->get('mercadopago.sandbox', config('mercadopago.sandbox', true)),
                FILTER_VALIDATE_BOOLEAN
            ),
        ];
    }

    public function inscriptionRequired(): bool
    {
        $settings = $this->all();

        return $settings['inscription_enabled'] && $settings['inscription_amount'] > 0;
    }

    public function isConfigured(): bool
    {
        $settings = $this->all();

        return $this->inscriptionRequired() && $settings['access_token'] !== '';
    }

    public function save(array $data): float
    {
        $amount = parse_brazilian_money($data['inscription_amount'] ?? 0);

        $this->put('payment.inscription_enabled', ! empty($data['inscription_enabled']) ? '1' : '0');
        $this->put('payment.inscription_amount', (string) $amount);
        $this->put('payment.inscription_description', $data['inscription_description'] ?? '');
        $this->put('mercadopago.public_key', $data['public_key'] ?? '');
        $this->put('mercadopago.sandbox', ! empty($data['sandbox']) ? '1' : '0');

        if (! empty($data['access_token'])) {
            $this->put('mercadopago.access_token', Crypt::encryptString($data['access_token']));
        }

        return $amount;
    }

    public function applyToConfig(): void
    {
        $settings = $this->all();

        config([
            'payment.inscription_enabled' => $settings['inscription_enabled'],
            'payment.inscription_amount' => $settings['inscription_amount'],
            'payment.inscription_description' => $settings['inscription_description'],
            'mercadopago.public_key' => $settings['public_key'],
            'mercadopago.access_token' => $settings['access_token'],
            'mercadopago.sandbox' => $settings['sandbox'],
        ]);
    }

    private function put(string $key, ?string $value): void
    {
        Setting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
    }

    private function decryptToken(mixed $value): string
    {
        if (blank($value)) {
            return (string) config('mercadopago.access_token', '');
        }

        try {
            return Crypt::decryptString((string) $value);
        } catch (\Throwable) {
            return (string) $value;
        }
    }
}