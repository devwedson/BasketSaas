@extends('layouts.attex.app')

@section('title', $club->name)

@section('content')
@include('partials.attex.show-header', [
    'title' => $club->name,
    'subtitle' => $club->city.($club->state ? ' - '.$club->state : ''),
    'media' => $club->logo ? '<img src="'.e(club_logo_url($club)).'" alt="'.e($club->name).'" class="h-16 w-16 object-contain rounded border border-gray-200 dark:border-gray-700 p-1">' : null,
    'editUrl' => route('clubs.edit', $club),
    'backUrl' => route('clubs.index'),
])

<div class="grid md:grid-cols-3 gap-6 mb-6">
    @include('partials.attex.stat-card', ['label' => 'Times', 'value' => $club->teams_count, 'icon' => 'ri-team-line'])
    @include('partials.attex.stat-card', ['label' => 'Jogadores', 'value' => $club->players_count, 'icon' => 'ri-user-star-line'])
    @include('partials.attex.stat-card', ['label' => 'Comissão', 'value' => $club->staff_count, 'icon' => 'ri-user-settings-line'])
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Informações do Clube</h4>
    </div>
    <div class="p-6">
        <dl class="grid md:grid-cols-2 gap-6">
            @include('partials.attex.detail-item', ['label' => 'E-mail', 'value' => $club->email])
            @include('partials.attex.detail-item', ['label' => 'Telefone', 'value' => $club->phone])
            @include('partials.attex.detail-item', ['label' => 'Endereço', 'value' => $club->address])
            @include('partials.attex.detail-item', ['label' => 'CEP', 'value' => $club->zip_code])
            @include('partials.attex.detail-item', ['label' => 'Cidade', 'value' => $club->city])
            @include('partials.attex.detail-item', ['label' => 'Estado', 'value' => $club->state])
            @include('partials.attex.detail-item', ['label' => 'País', 'value' => $club->country])
            @include('partials.attex.detail-item', ['label' => 'Status', 'value' => $club->is_active ? 'Ativo' : 'Inativo'])
            @if ($club->description)
                <div class="md:col-span-2">
                    @include('partials.attex.detail-item', ['label' => 'Descrição', 'value' => $club->description])
                </div>
            @endif
        </dl>
    </div>
</div>
@endsection