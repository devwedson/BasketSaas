<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Services\LandingSettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
            'clubs' => $clubs,
            'ctaRoutes' => [
                'login' => 'Login',
                'register' => 'Cadastro',
                'landing.contact' => 'Contato',
            ],
        ]);
    }

    public function update(Request $request, LandingSettingsService $landing): RedirectResponse
    {
        $data = $request->validate([
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
            'cta_header_route' => ['nullable', 'string', Rule::in(['login', 'register', 'landing.contact'])],
            'footer_newsletter_title' => ['nullable', 'string', 'max:255'],
        ]);

        if ($request->hasFile('brand_logo')) {
            $data['brand_logo_path'] = $request->file('brand_logo')->store('landing/brand', 'public');
        }

        if ($request->hasFile('brand_favicon')) {
            $data['brand_favicon_path'] = $request->file('brand_favicon')->store('landing/brand', 'public');
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