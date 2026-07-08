@php
    $imageLabels = [
        'about_secondary' => 'Sobre — imagem secundária',
        'testimonial' => 'Depoimentos',
        'faq' => 'FAQ (home)',
        'contact' => 'Contato (página)',
    ];
@endphp

<section>
    <h5 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-4">Imagens das seções</h5>
    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Substitui os assets padrão do tema Neodunk nas seções indicadas.</p>

    <div class="grid md:grid-cols-2 gap-6">
        @foreach ($imageKeys as $key => $fallback)
            @php
                $current = $settings['images'][$key] ?? $fallback;
                $previewUrl = landing_image($key, $fallback);
            @endphp
            <div>
                <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">{{ $imageLabels[$key] ?? $key }}</label>
                <input type="file" name="image_{{ $key }}" class="form-input" accept="image/*">
                <div class="mt-2 p-3 rounded border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    <img src="{{ $previewUrl }}" alt="{{ $imageLabels[$key] ?? $key }}" class="h-24 w-full object-cover rounded">
                </div>
            </div>
        @endforeach
    </div>
</section>