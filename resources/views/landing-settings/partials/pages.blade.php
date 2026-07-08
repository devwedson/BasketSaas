@php
    $sections = $settings['sections'];
    $pageBlocks = [
        'page_contact' => 'Página Contato',
        'page_about' => 'Página Sobre',
        'page_faqs' => 'Página FAQ',
        'page_team' => 'Página Equipes',
        'page_programs' => 'Página Programas',
        'page_matches' => 'Página Jogos',
        'page_blog' => 'Página Notícias',
    ];
    $fieldLabels = [
        'header_title' => 'Título do cabeçalho',
        'upcoming_subtitle' => 'Próximos jogos — subtítulo',
        'upcoming_title' => 'Próximos jogos — título',
        'recent_subtitle' => 'Resultados — subtítulo',
        'recent_title' => 'Resultados — título',
        'subtitle' => 'Subtítulo',
        'title' => 'Título',
        'description' => 'Descrição',
        'form_title' => 'Título do formulário',
        'form_subtitle' => 'Subtítulo do formulário',
        'map_subtitle' => 'Subtítulo do mapa',
        'map_title' => 'Título do mapa',
        'map_description' => 'Descrição do mapa',
        'trusted_text' => 'Texto de confiança',
        'sidebar_cta_title' => 'Título CTA lateral',
        'sidebar_cta_text' => 'Texto CTA lateral',
    ];
@endphp

<p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
    Placeholders: <code>{club}</code>, <code>{players}</code>, <code>{teams}</code>, <code>{games}</code>
</p>

@foreach ($pageBlocks as $sectionKey => $sectionTitle)
    <section class="{{ $loop->first ? '' : 'border-t border-gray-200 dark:border-gray-700 pt-8 mt-8' }}">
        <h5 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-4">{{ $sectionTitle }}</h5>
        <div class="grid md:grid-cols-2 gap-4">
            @foreach ($sectionDefaults[$sectionKey] ?? [] as $fieldKey => $defaultValue)
                @php
                    $name = "sections[{$sectionKey}][{$fieldKey}]";
                    $value = $sections[$sectionKey][$fieldKey] ?? $defaultValue;
                    $label = $fieldLabels[$fieldKey] ?? ucfirst(str_replace('_', ' ', $fieldKey));
                    $isLong = in_array($fieldKey, ['description', 'map_description', 'sidebar_cta_text', 'trusted_text'], true);
                @endphp
                @include('landing-settings.partials.field-text', [
                    'name' => $name,
                    'label' => $label,
                    'value' => $value,
                    'class' => $isLong ? 'md:col-span-2' : '',
                    'rows' => $isLong ? 2 : 1,
                ])
            @endforeach
        </div>
    </section>
@endforeach