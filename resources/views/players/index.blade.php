@extends('layouts.attex.app')

@section('title', 'Jogadores')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Jogadores',
    'subtitle' => 'Cadastro de atletas e fotos para a landing',
    'breadcrumbs' => [['label' => 'Dashboard', 'url' => route('dashboard')], ['label' => 'Jogadores']],
    'actionUrl' => route('players.create'),
    'actionLabel' => 'Novo Jogador',
    'actionIcon' => 'ri-add-line',
])

@php
    $gridColumns = [
        ['name' => 'Atleta', 'html' => true],
        ['name' => 'Nº'],
        ['name' => 'Posição'],
        ['name' => 'Time'],
        ['name' => 'Status', 'html' => true],
        ['name' => 'Ações', 'html' => true, 'sort' => false, 'width' => '150px'],
    ];
    $gridRows = $players->map(fn ($player) => [
        '<div class="flex items-center gap-3"><img src="'.e(player_photo_url($player)).'" class="h-9 w-9 rounded-full object-cover border border-gray-100 dark:border-gray-700" alt=""><span class="font-medium text-slate-800 dark:text-slate-200">'.e($player->name).'</span></div>',
        e($player->number ?? '-'),
        e($player->position?->label() ?? '-'),
        e($player->team?->name ?? '-'),
        attex_status_badge_html($player->is_active),
        attex_row_actions_html(route('players.show', $player), route('players.edit', $player), route('players.destroy', $player)),
    ])->values()->all();
@endphp

@include('partials.attex.data-table', [
    'title' => 'Lista de Jogadores',
    'count' => $players->count(),
    'columns' => $gridColumns,
    'rows' => $gridRows,
])
@endsection