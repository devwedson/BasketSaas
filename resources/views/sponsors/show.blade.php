@extends('layouts.attex.app')

@section('title', $sponsor->name)

@section('content')
@include('partials.attex.show-header', [
    'title' => $sponsor->name,
    'subtitle' => $sponsor->tier->label().($sponsor->website ? ' · '.$sponsor->website : ''),
    'media' => '<img src="'.e(sponsor_logo_url($sponsor)).'" alt="'.e($sponsor->name).'" class="h-16 w-28 object-contain rounded border border-gray-200 dark:border-gray-700 p-1 bg-white dark:bg-gray-800">',
    'editUrl' => route('sponsors.edit', $sponsor),
    'backUrl' => route('sponsors.index'),
])

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Detalhes do Patrocínio</h4>
    </div>
    <div class="p-6">
        <dl class="grid md:grid-cols-2 gap-6">
            @if (auth()->user()->isSuperAdmin())
                @include('partials.attex.detail-item', ['label' => 'Clube', 'value' => $sponsor->club->name])
            @endif
            @include('partials.attex.detail-item', ['label' => 'Nível', 'value' => $sponsor->tier->label()])
            @include('partials.attex.detail-item', ['label' => 'Site', 'value' => $sponsor->website])
            @include('partials.attex.detail-item', [
                'label' => 'Valor do Contrato',
                'value' => $sponsor->contract_amount ? 'R$ '.number_format($sponsor->contract_amount, 2, ',', '.') : null,
            ])
            @include('partials.attex.detail-item', ['label' => 'Início', 'value' => $sponsor->starts_at?->format('d/m/Y')])
            @include('partials.attex.detail-item', ['label' => 'Fim', 'value' => $sponsor->ends_at?->format('d/m/Y')])
            @include('partials.attex.detail-item', ['label' => 'Contato', 'value' => $sponsor->contact_name])
            @include('partials.attex.detail-item', ['label' => 'E-mail', 'value' => $sponsor->contact_email])
            @include('partials.attex.detail-item', ['label' => 'Telefone', 'value' => $sponsor->contact_phone])
            @include('partials.attex.detail-item', ['label' => 'Ordem na Landing', 'value' => $sponsor->sort_order])
            @include('partials.attex.detail-item', ['label' => 'Exibir na Landing', 'value' => $sponsor->show_on_landing ? 'Sim' : 'Não'])
            @include('partials.attex.detail-item', ['label' => 'Status', 'value' => $sponsor->is_active ? 'Ativo' : 'Inativo'])
            @include('partials.attex.detail-item', ['label' => 'Contrato Vigente', 'value' => $sponsor->isContractActive() ? 'Sim' : 'Não'])
            @if ($sponsor->notes)
                <div class="md:col-span-2">
                    @include('partials.attex.detail-item', ['label' => 'Observações', 'value' => $sponsor->notes])
                </div>
            @endif
        </dl>
    </div>
</div>
@endsection