@extends('layouts.attex.app')

@section('title', $team->name)

@section('content')
@include('partials.attex.show-header', [
    'title' => $team->name,
    'subtitle' => ($team->category ?? 'Sem categoria').' · '.($team->season?->name ?? 'Sem temporada'),
    'media' => '<img src="'.e(team_logo_url($team)).'" alt="'.e($team->name).'" class="h-16 w-16 object-contain rounded border border-gray-200 dark:border-gray-700 p-1">',
    'editUrl' => route('teams.edit', $team),
    'backUrl' => route('teams.index'),
])

<div class="grid md:grid-cols-4 gap-6 mb-6">
    @include('partials.attex.stat-card', ['label' => 'Jogadores', 'value' => $team->players_count, 'icon' => 'ri-user-star-line'])
    @include('partials.attex.stat-card', ['label' => 'Comissão', 'value' => $team->staff_count, 'icon' => 'ri-user-settings-line'])
    @include('partials.attex.stat-card', ['label' => 'Treinos', 'value' => $team->trainings_count, 'icon' => 'ri-basketball-line'])
    @include('partials.attex.stat-card', ['label' => 'Jogos', 'value' => $team->games_count, 'icon' => 'ri-trophy-line'])
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Detalhes do Time</h4>
    </div>
    <div class="p-6">
        <dl class="grid md:grid-cols-2 gap-6">
            @include('partials.attex.detail-item', ['label' => 'Clube', 'value' => $team->club->name])
            @include('partials.attex.detail-item', ['label' => 'Categoria', 'value' => $team->category])
            @include('partials.attex.detail-item', ['label' => 'Temporada', 'value' => $team->season?->name])
            @include('partials.attex.detail-item', ['label' => 'Status', 'value' => $team->is_active ? 'Ativo' : 'Inativo'])
            @include('partials.attex.detail-item', ['label' => 'Descrição', 'value' => $team->description])
            @include('partials.attex.detail-item', ['label' => 'Uniforme', 'value' => $team->uniform_description])
            @if ($team->cover_image)
                <div class="md:col-span-2">
                    <dt class="text-sm text-gray-500 dark:text-gray-400 mb-2">Capa (landing)</dt>
                    <dd><img src="{{ team_cover_image_url($team) }}" alt="{{ $team->name }}" class="h-32 max-w-sm object-cover rounded border border-gray-200 dark:border-gray-700"></dd>
                </div>
            @endif
        </dl>
    </div>
</div>
@endsection