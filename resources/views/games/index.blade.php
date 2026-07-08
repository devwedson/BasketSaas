@extends('layouts.attex.app')

@section('title', 'Jogos')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Jogos',
    'subtitle' => 'Calendário, placares, logos e capas para a landing',
    'breadcrumbs' => [['label' => 'Dashboard', 'url' => route('dashboard')], ['label' => 'Jogos']],
    'actionUrl' => route('games.create'),
    'actionLabel' => 'Novo Jogo',
    'actionIcon' => 'ri-add-line',
])

@php
    $gridColumns = [
        ['name' => 'Confronto', 'html' => true],
        ['name' => 'Data/Hora'],
        ['name' => 'Placar', 'html' => true],
        ['name' => 'Time'],
        ['name' => 'Ações', 'html' => true, 'sort' => false, 'width' => '150px'],
    ];
    $gridRows = $games->map(function ($game) {
        $confronto = '<div class="flex items-center gap-3">'
            .'<img src="'.e(team_logo_url($game->team, 'images/team-logo-1.png')).'" class="h-8 w-8 object-contain" alt="">'
            .'<span class="text-gray-400 dark:text-gray-500">vs</span>'
            .'<img src="'.e(game_opponent_logo_url($game)).'" class="h-8 w-8 object-contain" alt="">'
            .'<span class="font-medium text-slate-800 dark:text-slate-200">'.e($game->opponent).'</span>'
            .'</div>';
        $placar = $game->home_score !== null
            ? '<span class="inline-flex py-1 px-2 rounded-md bg-primary/10 text-primary text-xs font-medium">'.e($game->home_score).' x '.e($game->away_score).'</span>'
            : '-';

        return [
            $confronto,
            e($game->scheduled_at->format('d/m/Y H:i')),
            $placar,
            e($game->team?->name ?? '-'),
            attex_row_actions_html(route('games.show', $game), route('games.edit', $game), route('games.destroy', $game)),
        ];
    })->values()->all();
@endphp

@include('partials.attex.data-table', [
    'title' => 'Lista de Jogos',
    'count' => $games->count(),
    'columns' => $gridColumns,
    'rows' => $gridRows,
])
@endsection