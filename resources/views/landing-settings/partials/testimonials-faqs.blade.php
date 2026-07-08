@php
    $testimonials = old('testimonials', $settings['testimonials']);
    $faqs = old('faqs', $settings['faqs']);
    if (count($testimonials) < 3) {
        $testimonials = array_pad($testimonials, 3, ['quote' => '']);
    }
@endphp

<section>
    <h5 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-4">Depoimentos</h5>
    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Até 3 citações exibidas no carrossel da home (pareadas com atletas em destaque).</p>
    <div class="space-y-4">
        @foreach ($testimonials as $index => $testimonial)
            @include('landing-settings.partials.field-text', [
                'name' => "testimonials[{$index}][quote]",
                'label' => 'Depoimento '.($index + 1),
                'value' => $testimonial['quote'] ?? '',
                'rows' => 3,
            ])
        @endforeach
    </div>
</section>

<section class="border-t border-gray-200 dark:border-gray-700 pt-8 mt-8">
    <h5 class="text-sm font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400 mb-4">Perguntas frequentes</h5>
    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Categorias e perguntas exibidas na home e na página FAQ.</p>

    <div class="space-y-8" id="faq-categories">
        @foreach ($faqs as $catIndex => $category)
            <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800/30">
                <div class="grid md:grid-cols-2 gap-4 mb-4">
                    @include('landing-settings.partials.field-text', [
                        'name' => "faqs[{$catIndex}][category]",
                        'label' => 'Categoria '.($catIndex + 1),
                        'value' => $category['category'] ?? '',
                    ])
                    @include('landing-settings.partials.field-text', [
                        'name' => "faqs[{$catIndex}][id]",
                        'label' => 'ID âncora (sem espaços)',
                        'value' => $category['id'] ?? '',
                        'hint' => 'Ex.: faq_geral',
                    ])
                </div>

                <div class="space-y-4">
                    @foreach ($category['items'] ?? [] as $itemIndex => $item)
                        <div class="p-3 rounded border border-gray-200 dark:border-gray-600 bg-white dark:bg-gray-900">
                            @include('landing-settings.partials.field-text', [
                                'name' => "faqs[{$catIndex}][items][{$itemIndex}][question]",
                                'label' => 'Pergunta',
                                'value' => $item['question'] ?? '',
                            ])
                            @include('landing-settings.partials.field-text', [
                                'name' => "faqs[{$catIndex}][items][{$itemIndex}][answer]",
                                'label' => 'Resposta',
                                'value' => $item['answer'] ?? '',
                                'rows' => 3,
                            ])
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</section>