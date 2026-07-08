@extends('layouts.attex.app')

@section('title', $player->name)

@section('content')
@include('partials.attex.show-header', [
    'title' => $player->name,
    'subtitle' => '#'.($player->number ?? '-').' · '.($player->position?->label() ?? 'Sem posição'),
    'media' => '<img src="'.e(player_photo_url($player)).'" alt="'.e($player->name).'" class="h-16 w-16 rounded-full object-cover border border-gray-200 dark:border-gray-700">',
    'editUrl' => route('players.edit', $player),
    'backUrl' => route('players.index'),
])

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Detalhes do Atleta</h4>
    </div>
    <div class="p-6">
        <dl class="grid md:grid-cols-2 gap-6">
            @include('partials.attex.detail-item', ['label' => 'Time', 'value' => $player->team?->name])
            @include('partials.attex.detail-item', ['label' => 'Clube', 'value' => $player->club->name])
            @include('partials.attex.detail-item', ['label' => 'Altura', 'value' => $player->height_cm ? $player->height_cm.' cm' : null])
            @include('partials.attex.detail-item', ['label' => 'Peso', 'value' => $player->weight_kg ? $player->weight_kg.' kg' : null])
            @include('partials.attex.detail-item', ['label' => 'Nascimento', 'value' => $player->birth_date?->format('d/m/Y')])
            @include('partials.attex.detail-item', ['label' => 'E-mail', 'value' => $player->email])
            @include('partials.attex.detail-item', ['label' => 'Telefone', 'value' => $player->phone])
            @include('partials.attex.detail-item', ['label' => 'Responsável', 'value' => $player->guardian_name])
            @include('partials.attex.detail-item', ['label' => 'Tel. Responsável', 'value' => $player->guardian_phone])
            @include('partials.attex.detail-item', ['label' => 'E-mail Responsável', 'value' => $player->guardian_email])
            @include('partials.attex.detail-item', ['label' => 'Status', 'value' => $player->is_active ? 'Ativo' : 'Inativo'])
        </dl>
    </div>
</div>
@endsection