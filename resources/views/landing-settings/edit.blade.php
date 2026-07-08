@extends('layouts.attex.app')

@section('title', 'Configurações da Landing')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Configurações da Landing',
    'subtitle' => 'Marca, textos, menu, depoimentos, FAQ e imagens do site público',
    'breadcrumbs' => [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Landing'],
    ],
    'actionsView' => 'landing-settings.partials.landing-link',
])

@include('partials.attex.form-card-open', [
    'formTitle' => 'Site Público (Landing)',
    'formSubtitle' => 'Todas as alterações refletem na home e nas páginas internas',
    'formAction' => route('landing.settings.update'),
    'formMethod' => 'PUT',
    'enctype' => 'multipart/form-data',
])
    <div class="mb-6 border-b border-gray-200 dark:border-gray-700">
        <nav class="flex flex-wrap gap-2 -mb-px" role="tablist">
            @foreach ([
                'geral' => 'Geral',
                'home' => 'Home',
                'depoimentos' => 'Depoimentos & FAQ',
                'paginas' => 'Páginas',
                'menu' => 'Menu',
                'imagens' => 'Imagens',
            ] as $tabId => $tabLabel)
                <button
                    type="button"
                    class="landing-tab-btn px-4 py-2 text-sm font-medium border-b-2 transition-colors {{ $loop->first ? 'border-primary text-primary' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400' }}"
                    data-tab="{{ $tabId }}"
                    role="tab"
                >{{ $tabLabel }}</button>
            @endforeach
        </nav>
    </div>

    <div class="space-y-8">
        <div class="landing-tab-panel" data-panel="geral">
            @include('landing-settings.partials.general')
        </div>
        <div class="landing-tab-panel hidden" data-panel="home">
            @include('landing-settings.partials.home-sections')
        </div>
        <div class="landing-tab-panel hidden" data-panel="depoimentos">
            @include('landing-settings.partials.testimonials-faqs')
        </div>
        <div class="landing-tab-panel hidden" data-panel="paginas">
            @include('landing-settings.partials.pages')
        </div>
        <div class="landing-tab-panel hidden" data-panel="menu">
            @include('landing-settings.partials.menu')
        </div>
        <div class="landing-tab-panel hidden" data-panel="imagens">
            @include('landing-settings.partials.images')
        </div>
    </div>
@include('partials.attex.form-card-close', ['cancelUrl' => route('dashboard'), 'cancelLabel' => 'Voltar', 'submitLabel' => 'Salvar Landing'])

@include('landing-settings.partials.hosting-maintenance')

@push('scripts')
<script>
document.querySelectorAll('.landing-tab-btn').forEach(function (btn) {
    btn.addEventListener('click', function () {
        var tab = btn.dataset.tab;
        document.querySelectorAll('.landing-tab-btn').forEach(function (b) {
            b.classList.remove('border-primary', 'text-primary');
            b.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
        });
        btn.classList.add('border-primary', 'text-primary');
        btn.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
        document.querySelectorAll('.landing-tab-panel').forEach(function (panel) {
            panel.classList.toggle('hidden', panel.dataset.panel !== tab);
        });
    });
});
</script>
@endpush
@endsection