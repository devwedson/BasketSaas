<?php

namespace App\Services;

use App\Models\Setting;

class LandingSettingsService
{
    public const ROUTE_OPTIONS = [
        'landing' => 'Início',
        'landing.about' => 'Sobre',
        'landing.contact' => 'Contato',
        'landing.programs' => 'Programas',
        'landing.matches' => 'Jogos',
        'landing.team' => 'Equipes',
        'landing.blog' => 'Notícias',
        'landing.events' => 'Eventos',
        'landing.faqs' => 'FAQ',
        'login' => 'Login',
        'register' => 'Cadastro',
    ];

    public const IMAGE_KEYS = [
        'about_secondary' => 'images/about-us-image-2.jpg',
        'testimonial' => 'images/testimonial-image.jpg',
        'faq' => 'images/faq-image.jpg',
        'contact' => 'images/contact-us-image.jpg',
    ];

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
        'landing.sections',
        'landing.testimonials',
        'landing.faqs',
        'landing.menu',
        'landing.images.about_secondary',
        'landing.images.testimonial',
        'landing.images.faq',
        'landing.images.contact',
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
            'sections' => $this->mergedSections($stored->get('landing.sections')),
            'testimonials' => $this->decodeJson($stored->get('landing.testimonials'), config('landing.testimonials', [])),
            'faqs' => $this->decodeJson($stored->get('landing.faqs'), config('landing.faqs', [])),
            'menu' => $this->decodeJson($stored->get('landing.menu'), config('landing.menu', [])),
            'images' => $this->mergedImages($stored),
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

        if (isset($data['sections']) && is_array($data['sections'])) {
            $this->putJson('landing.sections', $this->sanitizeSections($data['sections']));
        }

        if (isset($data['testimonials']) && is_array($data['testimonials'])) {
            $this->putJson('landing.testimonials', $this->sanitizeTestimonials($data['testimonials']));
        }

        if (isset($data['faqs']) && is_array($data['faqs'])) {
            $this->putJson('landing.faqs', $this->sanitizeFaqs($data['faqs']));
        }

        if (isset($data['menu']) && is_array($data['menu'])) {
            $this->putJson('landing.menu', $this->sanitizeMenu($data['menu']));
        }

        foreach (array_keys(self::IMAGE_KEYS) as $imageKey) {
            $pathKey = "image_{$imageKey}_path";
            if (! empty($data[$pathKey])) {
                $this->put("landing.images.{$imageKey}", $data[$pathKey]);
            }
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
            'landing.sections' => $settings['sections'],
            'landing.testimonials' => $settings['testimonials'],
            'landing.faqs' => $settings['faqs'],
            'landing.menu' => $settings['menu'],
            'landing.images' => $settings['images'],
        ]);
    }

    public function sectionDefaults(): array
    {
        return config('landing_sections', []);
    }

    private function mergedSections(?string $storedJson): array
    {
        $defaults = $this->sectionDefaults();
        $stored = $this->decodeJson($storedJson, []);

        return $this->deepMerge($defaults, $stored);
    }

    private function mergedImages($stored): array
    {
        $images = [];

        foreach (self::IMAGE_KEYS as $key => $fallback) {
            $settingKey = "landing.images.{$key}";
            $images[$key] = (string) ($stored->get($settingKey) ?: $fallback);
        }

        return $images;
    }

    private function decodeJson(?string $value, array $fallback): array
    {
        if (blank($value)) {
            return $fallback;
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : $fallback;
    }

    private function putJson(string $key, array $value): void
    {
        $this->put($key, json_encode($value, JSON_UNESCAPED_UNICODE));
    }

    private function sanitizeSections(array $sections): array
    {
        $defaults = $this->sectionDefaults();
        $sanitized = [];

        foreach ($defaults as $sectionKey => $fields) {
            $input = $sections[$sectionKey] ?? [];
            $sanitized[$sectionKey] = [];

            foreach ($fields as $fieldKey => $defaultValue) {
                $value = $input[$fieldKey] ?? $defaultValue;
                $sanitized[$sectionKey][$fieldKey] = is_string($value)
                    ? trim($value)
                    : (string) $value;
            }
        }

        return $sanitized;
    }

    private function sanitizeTestimonials(array $testimonials): array
    {
        return collect($testimonials)
            ->map(fn ($item) => ['quote' => trim((string) ($item['quote'] ?? ''))])
            ->filter(fn ($item) => $item['quote'] !== '')
            ->values()
            ->take(6)
            ->all();
    }

    private function sanitizeFaqs(array $faqs): array
    {
        return collect($faqs)
            ->map(function ($category, $index) {
                $items = collect($category['items'] ?? [])
                    ->map(fn ($item) => [
                        'question' => trim((string) ($item['question'] ?? '')),
                        'answer' => trim((string) ($item['answer'] ?? '')),
                    ])
                    ->filter(fn ($item) => $item['question'] !== '' && $item['answer'] !== '')
                    ->values()
                    ->all();

                $id = trim((string) ($category['id'] ?? ''));
                if ($id === '') {
                    $id = 'faq_'.($index + 1);
                }

                return [
                    'category' => trim((string) ($category['category'] ?? '')),
                    'id' => preg_replace('/[^a-z0-9_]/i', '_', $id) ?: 'faq_'.($index + 1),
                    'items' => $items,
                ];
            })
            ->filter(fn ($category) => $category['category'] !== '' && ! empty($category['items']))
            ->values()
            ->all();
    }

    private function sanitizeMenu(array $menu): array
    {
        $allowedRoutes = array_keys(self::ROUTE_OPTIONS);

        return collect($menu)
            ->map(fn ($item) => [
                'label' => trim((string) ($item['label'] ?? '')),
                'route' => in_array($item['route'] ?? '', $allowedRoutes, true)
                    ? $item['route']
                    : 'landing',
            ])
            ->filter(fn ($item) => $item['label'] !== '')
            ->values()
            ->all();
    }

    private function deepMerge(array $defaults, array $overrides): array
    {
        $merged = $defaults;

        foreach ($overrides as $key => $value) {
            if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
                $merged[$key] = $this->deepMerge($merged[$key], $value);
            } else {
                $merged[$key] = $value;
            }
        }

        return $merged;
    }

    private function put(string $key, ?string $value): void
    {
        Setting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
    }
}