@php
    $sections = $settings['sections'];
    $homeBlocks = [
        'hero' => 'Hero (topo da home)',
        'home_about' => 'Sobre (home)',
        'home_programs' => 'Programas (home)',
        'home_matches' => 'Jogos (home)',
        'home_team' => 'Equipe (home)',
        'home_cta' => 'CTA (home)',
        'home_testimonials' => 'Depoimentos (home)',
        'home_faqs' => 'FAQ (home)',
        'home_blog' => 'Notícias (home)',
    ];
    $fieldLabels = [
        'subtitle_prefix' => 'Subtítulo (prefixo)',
        'subtitle' => 'Subtítulo',
        'title' => 'Título',
        'description' => 'Descrição',
        'counter_suffix' => 'Sufixo do contador',
        'counter_label' => 'Rótulo do contador',
        'btn_primary' => 'Botão primário',
        'btn_primary_route' => 'Rota do botão primário',
        'btn_secondary' => 'Botão secundário',
        'btn_secondary_route' => 'Rota do botão secundário',
        'trusted_text' => 'Texto de confiança',
        'feature_1_title' => 'Destaque 1 — título',
        'feature_1_text' => 'Destaque 1 — texto',
        'feature_2_title' => 'Destaque 2 — título',
        'feature_2_text' => 'Destaque 2 — texto',
        'btn' => 'Botão',
        'btn_route' => 'Rota do botão',
        'footer_text' => 'Texto do rodapé',
        'footer_link' => 'Link do rodapé',
        'footer_route' => 'Rota do link',
        'sponsors_title' => 'Título dos patrocinadores',
        'sidebar_title' => 'Título da barra lateral',
    ];
@endphp

<p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
    Placeholders disponíveis: <code>{players}</code>, <code>{teams}</code>, <code>{games}</code>, <code>{club}</code>
</p>

@foreach ($homeBlocks as $sectionKey => $sectionTitle)
    <section class="{{ $loop->first ? '' : 'border-t border-gray-200 dark:border-gray-700 pt-8 mt-8' }}">
        <h5 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-4">{{ $sectionTitle }}</h5>
        <div class="grid md:grid-cols-2 gap-4">
            @foreach ($sectionDefaults[$sectionKey] ?? [] as $fieldKey => $defaultValue)
                @php
                    $name = "sections[{$sectionKey}][{$fieldKey}]";
                    $value = $sections[$sectionKey][$fieldKey] ?? $defaultValue;
                    $label = $fieldLabels[$fieldKey] ?? ucfirst(str_replace('_', ' ', $fieldKey));
                    $isRoute = str_ends_with($fieldKey, '_route');
                    $isLong = in_array($fieldKey, ['description', 'feature_1_text', 'feature_2_text', 'trusted_text', 'footer_text'], true);
                @endphp
                @if ($isRoute)
                    @include('landing-settings.partials.field-route', [
                        'name' => $name,
                        'label' => $label,
                        'value' => $value,
                    ])
                @else
                    @include('landing-settings.partials.field-text', [
                        'name' => $name,
                        'label' => $label,
                        'value' => $value,
                        'class' => $isLong ? 'md:col-span-2' : '',
                        'rows' => $isLong ? 2 : 1,
                    ])
                @endif
            @endforeach
        </div>
    </section>
@endforeach