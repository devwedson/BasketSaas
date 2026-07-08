<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Crypt;

class SmtpSettingsService
{
    public const KEYS = [
        'smtp.enabled',
        'smtp.host',
        'smtp.port',
        'smtp.username',
        'smtp.password',
        'smtp.encryption',
        'smtp.from_address',
        'smtp.from_name',
    ];

    public function all(): array
    {
        $stored = Setting::query()
            ->whereIn('key', self::KEYS)
            ->pluck('value', 'key');

        return [
            'enabled' => filter_var($stored->get('smtp.enabled'), FILTER_VALIDATE_BOOLEAN),
            'host' => (string) $stored->get('smtp.host', ''),
            'port' => (int) ($stored->get('smtp.port') ?: 587),
            'username' => (string) $stored->get('smtp.username', ''),
            'password' => $this->decryptPassword($stored->get('smtp.password')),
            'encryption' => (string) $stored->get('smtp.encryption', 'tls'),
            'from_address' => (string) $stored->get('smtp.from_address', config('mail.from.address')),
            'from_name' => (string) $stored->get('smtp.from_name', config('mail.from.name')),
        ];
    }

    public function isConfigured(): bool
    {
        $settings = $this->all();

        return $settings['enabled']
            && $settings['host'] !== ''
            && $settings['from_address'] !== '';
    }

    public function save(array $data): void
    {
        $this->put('smtp.enabled', ! empty($data['enabled']) ? '1' : '0');
        $this->put('smtp.host', $data['host'] ?? '');
        $this->put('smtp.port', (string) ($data['port'] ?? 587));
        $this->put('smtp.username', $data['username'] ?? '');
        $this->put('smtp.encryption', $data['encryption'] ?? 'tls');
        $this->put('smtp.from_address', $data['from_address'] ?? '');
        $this->put('smtp.from_name', $data['from_name'] ?? config('app.name'));

        if (! empty($data['password'])) {
            $this->put('smtp.password', Crypt::encryptString($data['password']));
        }
    }

    public function applyToConfig(): void
    {
        if (! $this->isConfigured()) {
            return;
        }

        $settings = $this->all();

        config([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.host' => $settings['host'],
            'mail.mailers.smtp.port' => $settings['port'],
            'mail.mailers.smtp.username' => $settings['username'] ?: null,
            'mail.mailers.smtp.password' => $settings['password'] ?: null,
            'mail.mailers.smtp.encryption' => $settings['encryption'] === 'none' ? null : $settings['encryption'],
            'mail.from.address' => $settings['from_address'],
            'mail.from.name' => $settings['from_name'],
        ]);
    }

    private function put(string $key, ?string $value): void
    {
        Setting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
    }

    private function decryptPassword(?string $value): string
    {
        if (blank($value)) {
            return '';
        }

        try {
            return Crypt::decryptString($value);
        } catch (\Throwable) {
            return '';
        }
    }
}