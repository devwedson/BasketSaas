<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Services\LandingSettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LandingSettingsController extends Controller
{
    public function edit(LandingSettingsService $landing): View
    {
        $clubs = Club::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        return view('landing-settings.edit', [
            'settings' => $landing->all(),
            'sectionDefaults' => $landing->sectionDefaults(),
            'clubs' => $clubs,
            'ctaRoutes' => LandingSettingsService::ROUTE_OPTIONS,
            'imageKeys' => LandingSettingsService::IMAGE_KEYS,
        ]);
    }

    public function update(Request $request, LandingSettingsService $landing): RedirectResponse
    {
        $allowedRoutes = array_keys(LandingSettingsService::ROUTE_OPTIONS);

        $rules = [
            'brand_name' => ['required', 'string', 'max:255'],
            'brand_tagline' => ['nullable', 'string', 'max:500'],
            'brand_logo' => ['nullable', 'image', 'max:2048'],
            'brand_favicon' => ['nullable', 'image', 'max:1024'],
            'contact_phone' => ['nullable', 'string', 'max:30'],
            'contact_phone_display' => ['nullable', 'string', 'max:50'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_address' => ['nullable', 'string', 'max:255'],
            'contact_hours' => ['nullable', 'string', 'max:255'],
            'social_facebook' => ['nullable', 'url', 'max:255'],
            'social_instagram' => ['nullable', 'url', 'max:255'],
            'social_linkedin' => ['nullable', 'url', 'max:255'],
            'social_youtube' => ['nullable', 'url', 'max:255'],
            'featured_club_slug' => ['nullable', 'string', 'max:100'],
            'cta_header_label' => ['nullable', 'string', 'max:50'],
            'cta_header_route' => ['nullable', 'string', Rule::in($allowedRoutes)],
            'footer_newsletter_title' => ['nullable', 'string', 'max:255'],
            'sections' => ['nullable', 'array'],
            'testimonials' => ['nullable', 'array'],
            'testimonials.*.quote' => ['nullable', 'string', 'max:2000'],
            'faqs' => ['nullable', 'array'],
            'faqs.*.category' => ['nullable', 'string', 'max:255'],
            'faqs.*.id' => ['nullable', 'string', 'max:100'],
            'faqs.*.items' => ['nullable', 'array'],
            'faqs.*.items.*.question' => ['nullable', 'string', 'max:500'],
            'faqs.*.items.*.answer' => ['nullable', 'string', 'max:5000'],
            'menu' => ['nullable', 'array'],
            'menu.*.label' => ['nullable', 'string', 'max:50'],
            'menu.*.route' => ['nullable', 'string', Rule::in($allowedRoutes)],
        ];

        foreach ($landing->sectionDefaults() as $sectionKey => $fields) {
            $rules["sections.{$sectionKey}"] = ['nullable', 'array'];
            foreach ($fields as $fieldKey => $default) {
                $max = str_ends_with($fieldKey, '_route') ? 100 : 2000;
                $rules["sections.{$sectionKey}.{$fieldKey}"] = ['nullable', 'string', "max:{$max}"];
            }
        }

        foreach (array_keys(LandingSettingsService::IMAGE_KEYS) as $imageKey) {
            $rules["image_{$imageKey}"] = ['nullable', 'image', 'max:4096'];
        }

        $data = $request->validate($rules);

        if ($request->hasFile('brand_logo')) {
            $data['brand_logo_path'] = $request->file('brand_logo')->store('landing/brand', 'public');
        }

        if ($request->hasFile('brand_favicon')) {
            $data['brand_favicon_path'] = $request->file('brand_favicon')->store('landing/brand', 'public');
        }

        foreach (array_keys(LandingSettingsService::IMAGE_KEYS) as $imageKey) {
            if ($request->hasFile("image_{$imageKey}")) {
                $data["image_{$imageKey}_path"] = $request->file("image_{$imageKey}")->store('landing/images', 'public');
            }
        }

        $validSlugs = Club::query()->where('is_active', true)->pluck('slug')->all();
        $slug = $data['featured_club_slug'] ?? '';
        if ($slug !== '' && ! in_array($slug, $validSlugs, true)) {
            return back()
                ->withInput()
                ->withErrors(['featured_club_slug' => 'Selecione um clube ativo válido.']);
        }

        $landing->save($data);
        $landing->applyToConfig();

        return redirect()
            ->route('landing.settings.edit')
            ->with('success', 'Configurações da landing salvas com sucesso.');
    }
}