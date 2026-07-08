<?php

namespace App\Services;

use App\Models\Setting;

class LandingSettingsService
{
    public const KEYS = [
        'landing.brand.name',
        'landing.brand.tagline',
        'landing.brand.logo',
        'landing.brand.favicon',
        'landing.contact.phone',
        'landing.contact.phone_display',
        'landing.contact.email',
        'landing.contact.address',
        'landing.contact.hours',
        'landing.social.facebook',
        'landing.social.instagram',
        'landing.social.linkedin',
        'landing.social.youtube',
        'landing.featured_club_slug',
        'landing.cta.header_label',
        'landing.cta.header_route',
        'landing.footer.newsletter_title',
    ];

    public function all(): array
    {
        $stored = Setting::query()
            ->whereIn('key', self::KEYS)
            ->pluck('value', 'key');

        return [
            'brand_name' => (string) ($stored->get('landing.brand.name') ?: config('landing.brand.name')),
            'brand_tagline' => (string) ($stored->get('landing.brand.tagline') ?: config('landing.brand.tagline')),
            'brand_logo' => (string) ($stored->get('landing.brand.logo') ?: config('landing.brand.logo')),
            'brand_favicon' => (string) ($stored->get('landing.brand.favicon') ?: config('landing.brand.favicon')),
            'contact_phone' => (string) ($stored->get('landing.contact.phone') ?: config('landing.contact.phone', '')),
            'contact_phone_display' => (string) ($stored->get('landing.contact.phone_display') ?: config('landing.contact.phone_display', '')),
            'contact_email' => (string) ($stored->get('landing.contact.email') ?: config('landing.contact.email', '')),
            'contact_address' => (string) ($stored->get('landing.contact.address') ?: config('landing.contact.address', '')),
            'contact_hours' => (string) ($stored->get('landing.contact.hours') ?: config('landing.contact.hours', '')),
            'social_facebook' => (string) ($stored->get('landing.social.facebook') ?: config('landing.social.facebook', '')),
            'social_instagram' => (string) ($stored->get('landing.social.instagram') ?: config('landing.social.instagram', '')),
            'social_linkedin' => (string) ($stored->get('landing.social.linkedin') ?: config('landing.social.linkedin', '')),
            'social_youtube' => (string) ($stored->get('landing.social.youtube') ?: config('landing.social.youtube', '')),
            'featured_club_slug' => (string) ($stored->get('landing.featured_club_slug') ?: config('landing.featured_club_slug', '')),
            'cta_header_label' => (string) ($stored->get('landing.cta.header_label') ?: config('landing.cta.header_label')),
            'cta_header_route' => (string) ($stored->get('landing.cta.header_route') ?: config('landing.cta.header_route')),
            'footer_newsletter_title' => (string) ($stored->get('landing.footer.newsletter_title') ?: config('landing.footer.newsletter_title')),
        ];
    }

    public function save(array $data): void
    {
        $this->put('landing.brand.name', $data['brand_name'] ?? '');
        $this->put('landing.brand.tagline', $data['brand_tagline'] ?? '');
        $this->put('landing.contact.phone', $data['contact_phone'] ?? '');
        $this->put('landing.contact.phone_display', $data['contact_phone_display'] ?? '');
        $this->put('landing.contact.email', $data['contact_email'] ?? '');
        $this->put('landing.contact.address', $data['contact_address'] ?? '');
        $this->put('landing.contact.hours', $data['contact_hours'] ?? '');
        $this->put('landing.social.facebook', $data['social_facebook'] ?? '');
        $this->put('landing.social.instagram', $data['social_instagram'] ?? '');
        $this->put('landing.social.linkedin', $data['social_linkedin'] ?? '');
        $this->put('landing.social.youtube', $data['social_youtube'] ?? '');
        $this->put('landing.featured_club_slug', $data['featured_club_slug'] ?? '');
        $this->put('landing.cta.header_label', $data['cta_header_label'] ?? '');
        $this->put('landing.cta.header_route', $data['cta_header_route'] ?? 'login');
        $this->put('landing.footer.newsletter_title', $data['footer_newsletter_title'] ?? '');

        if (! empty($data['brand_logo_path'])) {
            $this->put('landing.brand.logo', $data['brand_logo_path']);
        }

        if (! empty($data['brand_favicon_path'])) {
            $this->put('landing.brand.favicon', $data['brand_favicon_path']);
        }
    }

    public function applyToConfig(): void
    {
        $settings = $this->all();

        config([
            'landing.brand.name' => $settings['brand_name'],
            'landing.brand.tagline' => $settings['brand_tagline'],
            'landing.brand.logo' => $settings['brand_logo'],
            'landing.brand.favicon' => $settings['brand_favicon'],
            'landing.contact.phone' => $settings['contact_phone'] ?: null,
            'landing.contact.phone_display' => $settings['contact_phone_display'] ?: null,
            'landing.contact.email' => $settings['contact_email'] ?: null,
            'landing.contact.address' => $settings['contact_address'] ?: null,
            'landing.contact.hours' => $settings['contact_hours'] ?: null,
            'landing.social.facebook' => $settings['social_facebook'] ?: null,
            'landing.social.instagram' => $settings['social_instagram'] ?: null,
            'landing.social.linkedin' => $settings['social_linkedin'] ?: null,
            'landing.social.youtube' => $settings['social_youtube'] ?: null,
            'landing.featured_club_slug' => $settings['featured_club_slug'] ?: null,
            'landing.cta.header_label' => $settings['cta_header_label'],
            'landing.cta.header_route' => $settings['cta_header_route'],
            'landing.footer.newsletter_title' => $settings['footer_newsletter_title'],
        ]);
    }

    private function put(string $key, ?string $value): void
    {
        Setting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
    }
}