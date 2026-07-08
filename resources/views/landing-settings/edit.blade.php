@extends('layouts.attex.app')

@section('title', 'Configurações da Landing')

@section('content')
@php
    $logoUrl = is_custom_media_path($settings['brand_logo'])
        ? asset('storage/'.$settings['brand_logo'])
        : neodunk_asset($settings['brand_logo']);
    $faviconUrl = is_custom_media_path($settings['brand_favicon'])
        ? asset('storage/'.$settings['brand_favicon'])
        : neodunk_asset($settings['brand_favicon']);
@endphp

@include('partials.attex.page-header', [
    'title' => 'Configurações da Landing',
    'subtitle' => 'Marca, rodapé, contato, redes sociais e clube em destaque no site público',
    'breadcrumbs' => [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Landing'],
    ],
    'actionsView' => 'landing-settings.partials.landing-link',
])

@include('partials.attex.form-card-open', [
    'formTitle' => 'Site Público (Landing)',
    'formSubtitle' => 'Alterações refletem no header, rodapé e seções de contato',
    'formAction' => route('landing.settings.update'),
    'formMethod' => 'PUT',
    'enctype' => 'multipart/form-data',
])
    <div class="space-y-8">
        <section>
            <h5 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-4">Marca</h5>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Nome do sistema / clube *</label>
                    <input type="text" name="brand_name" class="form-input" value="{{ old('brand_name', $settings['brand_name']) }}" required>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Exibido no título das páginas e no rodapé quando o clube em destaque não tiver nome próprio.</p>
                </div>

                <div class="md:col-span-2">
                    <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Slogan (tagline)</label>
                    <textarea name="brand_tagline" class="form-input" rows="2">{{ old('brand_tagline', $settings['brand_tagline']) }}</textarea>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Texto curto no rodapé e meta description.</p>
                </div>

                <div>
                    <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Logo (header e rodapé)</label>
                    <input type="file" name="brand_logo" class="form-input" accept="image/*">
                    <div class="mt-2 p-3 rounded border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 inline-block">
                        <img src="{{ $logoUrl }}" alt="Logo atual" class="h-12 object-contain">
                    </div>
                </div>

                <div>
                    <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Favicon</label>
                    <input type="file" name="brand_favicon" class="form-input" accept="image/*,.ico">
                    <div class="mt-2 p-3 rounded border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 inline-block">
                        <img src="{{ $faviconUrl }}" alt="Favicon atual" class="h-8 w-8 object-contain">
                    </div>
                </div>
            </div>
        </section>

        <section class="border-t border-gray-200 dark:border-gray-700 pt-8">
            <h5 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-4">Header</h5>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Texto do botão</label>
                    <input type="text" name="cta_header_label" class="form-input" value="{{ old('cta_header_label', $settings['cta_header_label']) }}" placeholder="Entrar">
                </div>
                <div>
                    <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Destino do botão</label>
                    <select name="cta_header_route" class="form-select">
                        @foreach ($ctaRoutes as $route => $label)
                            <option value="{{ $route }}" @selected(old('cta_header_route', $settings['cta_header_route']) === $route)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </section>

        <section class="border-t border-gray-200 dark:border-gray-700 pt-8">
            <h5 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-4">Rodapé e contato</h5>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Título da newsletter</label>
                    <input type="text" name="footer_newsletter_title" class="form-input" value="{{ old('footer_newsletter_title', $settings['footer_newsletter_title']) }}">
                </div>

                <div>
                    <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Telefone</label>
                    <input type="text" name="contact_phone" class="form-input" value="{{ old('contact_phone', $settings['contact_phone']) }}" placeholder="11999999999">
                </div>

                <div>
                    <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Telefone (exibição)</label>
                    <input type="text" name="contact_phone_display" class="form-input" value="{{ old('contact_phone_display', $settings['contact_phone_display']) }}" placeholder="(11) 99999-9999">
                </div>

                <div>
                    <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">E-mail</label>
                    <input type="email" name="contact_email" class="form-input" value="{{ old('contact_email', $settings['contact_email']) }}">
                </div>

                <div>
                    <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Horário de atendimento</label>
                    <input type="text" name="contact_hours" class="form-input" value="{{ old('contact_hours', $settings['contact_hours']) }}" placeholder="Segunda a Sábado: 8h às 21h">
                </div>

                <div class="md:col-span-2">
                    <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Endereço</label>
                    <input type="text" name="contact_address" class="form-input" value="{{ old('contact_address', $settings['contact_address']) }}">
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Usado no rodapé e página de contato quando o clube em destaque não informar endereço.</p>
                </div>
            </div>
        </section>

        <section class="border-t border-gray-200 dark:border-gray-700 pt-8">
            <h5 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-4">Redes sociais</h5>
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Facebook</label>
                    <input type="url" name="social_facebook" class="form-input" value="{{ old('social_facebook', $settings['social_facebook']) }}" placeholder="https://facebook.com/...">
                </div>
                <div>
                    <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Instagram</label>
                    <input type="url" name="social_instagram" class="form-input" value="{{ old('social_instagram', $settings['social_instagram']) }}" placeholder="https://instagram.com/...">
                </div>
                <div>
                    <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">LinkedIn</label>
                    <input type="url" name="social_linkedin" class="form-input" value="{{ old('social_linkedin', $settings['social_linkedin']) }}" placeholder="https://linkedin.com/...">
                </div>
                <div>
                    <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">YouTube</label>
                    <input type="url" name="social_youtube" class="form-input" value="{{ old('social_youtube', $settings['social_youtube']) }}" placeholder="https://youtube.com/...">
                </div>
            </div>
        </section>

        <section class="border-t border-gray-200 dark:border-gray-700 pt-8">
            <h5 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-4">Clube em destaque</h5>
            <div class="grid md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Clube exibido na landing</label>
                    <select name="featured_club_slug" class="form-select">
                        <option value="">— Automático (primeiro clube ativo) —</option>
                        @foreach ($clubs as $club)
                            <option value="{{ $club->slug }}" @selected(old('featured_club_slug', $settings['featured_club_slug']) === $club->slug)>
                                {{ $club->name }} ({{ $club->slug }})
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Define qual clube alimenta jogos, atletas, patrocinadores e dados de contato na home.</p>
                </div>
            </div>
        </section>
    </div>
@include('partials.attex.form-card-close', ['cancelUrl' => route('dashboard'), 'cancelLabel' => 'Voltar', 'submitLabel' => 'Salvar Landing'])
@endsection