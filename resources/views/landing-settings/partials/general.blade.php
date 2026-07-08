@php
    $logoUrl = is_custom_media_path($settings['brand_logo'])
        ? asset('storage/'.$settings['brand_logo'])
        : neodunk_asset($settings['brand_logo']);
    $faviconUrl = is_custom_media_path($settings['brand_favicon'])
        ? asset('storage/'.$settings['brand_favicon'])
        : neodunk_asset($settings['brand_favicon']);
@endphp

<section>
    <h5 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-4">Marca</h5>
    <div class="grid md:grid-cols-2 gap-4">
        @include('landing-settings.partials.field-text', [
            'name' => 'brand_name',
            'label' => 'Nome do sistema / clube *',
            'value' => $settings['brand_name'],
            'class' => 'md:col-span-2',
            'hint' => 'Exibido no título das páginas e no rodapé.',
        ])
        @include('landing-settings.partials.field-text', [
            'name' => 'brand_tagline',
            'label' => 'Slogan (tagline)',
            'value' => $settings['brand_tagline'],
            'class' => 'md:col-span-2',
            'rows' => 2,
        ])
        <div>
            <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Logo</label>
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
        @include('landing-settings.partials.field-text', [
            'name' => 'cta_header_label',
            'label' => 'Texto do botão',
            'value' => $settings['cta_header_label'],
        ])
        @include('landing-settings.partials.field-route', [
            'name' => 'cta_header_route',
            'label' => 'Destino do botão',
            'value' => $settings['cta_header_route'],
        ])
    </div>
</section>

<section class="border-t border-gray-200 dark:border-gray-700 pt-8">
    <h5 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-4">Rodapé e contato</h5>
    <div class="grid md:grid-cols-2 gap-4">
        @include('landing-settings.partials.field-text', [
            'name' => 'footer_newsletter_title',
            'label' => 'Título da newsletter',
            'value' => $settings['footer_newsletter_title'],
            'class' => 'md:col-span-2',
        ])
        @include('landing-settings.partials.field-text', ['name' => 'contact_phone', 'label' => 'Telefone', 'value' => $settings['contact_phone']])
        @include('landing-settings.partials.field-text', ['name' => 'contact_phone_display', 'label' => 'Telefone (exibição)', 'value' => $settings['contact_phone_display']])
        @include('landing-settings.partials.field-text', ['name' => 'contact_email', 'label' => 'E-mail', 'value' => $settings['contact_email']])
        @include('landing-settings.partials.field-text', ['name' => 'contact_hours', 'label' => 'Horário de atendimento', 'value' => $settings['contact_hours']])
        @include('landing-settings.partials.field-text', [
            'name' => 'contact_address',
            'label' => 'Endereço',
            'value' => $settings['contact_address'],
            'class' => 'md:col-span-2',
        ])
    </div>
</section>

<section class="border-t border-gray-200 dark:border-gray-700 pt-8">
    <h5 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-4">Redes sociais</h5>
    <div class="grid md:grid-cols-2 gap-4">
        @include('landing-settings.partials.field-text', ['name' => 'social_facebook', 'label' => 'Facebook', 'value' => $settings['social_facebook']])
        @include('landing-settings.partials.field-text', ['name' => 'social_instagram', 'label' => 'Instagram', 'value' => $settings['social_instagram']])
        @include('landing-settings.partials.field-text', ['name' => 'social_linkedin', 'label' => 'LinkedIn', 'value' => $settings['social_linkedin']])
        @include('landing-settings.partials.field-text', ['name' => 'social_youtube', 'label' => 'YouTube', 'value' => $settings['social_youtube']])
    </div>
</section>

<section class="border-t border-gray-200 dark:border-gray-700 pt-8">
    <h5 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-4">Clube em destaque</h5>
    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Clube exibido na landing</label>
        <select name="featured_club_slug" class="form-select">
            <option value="">— Automático (primeiro clube ativo) —</option>
            @foreach ($clubs as $club)
                <option value="{{ $club->slug }}" @selected(old('featured_club_slug', $settings['featured_club_slug']) === $club->slug)>
                    {{ $club->name }} ({{ $club->slug }})
                </option>
            @endforeach
        </select>
    </div>
</section>