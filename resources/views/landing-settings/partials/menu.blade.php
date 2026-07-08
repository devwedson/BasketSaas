@php
    $menu = old('menu', $settings['menu']);
@endphp

<section>
    <h5 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-4">Itens do menu</h5>
    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Ordem e rótulos do menu principal do site público.</p>

    <div class="space-y-3">
        @foreach ($menu as $index => $item)
            <div class="grid md:grid-cols-2 gap-4 p-3 rounded border border-gray-200 dark:border-gray-700">
                @include('landing-settings.partials.field-text', [
                    'name' => "menu[{$index}][label]",
                    'label' => 'Item '.($index + 1).' — rótulo',
                    'value' => $item['label'] ?? '',
                ])
                @include('landing-settings.partials.field-route', [
                    'name' => "menu[{$index}][route]",
                    'label' => 'Destino',
                    'value' => $item['route'] ?? 'landing',
                ])
            </div>
        @endforeach
    </div>
</section>