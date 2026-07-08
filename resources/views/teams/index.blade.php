@extends('layouts.attex.app')

@section('title', 'Times')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Times',
    'subtitle' => 'Gerencie categorias, logos e elencos',
    'breadcrumbs' => [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Times'],
    ],
    'actionUrl' => route('teams.create'),
    'actionLabel' => 'Novo Time',
    'actionIcon' => 'ri-add-line',
])

@php
    $gridColumns = [
        ['name' => 'Time', 'html' => true],
        ['name' => 'Categoria'],
        ['name' => 'Temporada'],
    ];
    if (auth()->user()->isSuperAdmin()) {
        $gridColumns[] = ['name' => 'Clube'];
    }
    $gridColumns[] = ['name' => 'Status', 'html' => true];
    $gridColumns[] = ['name' => 'Ações', 'html' => true, 'sort' => false, 'width' => '150px'];

    $gridRows = $teams->map(function ($team) {
        $row = [
            '<div class="flex items-center gap-3"><img src="'.e(team_logo_url($team, 'images/team-logo-1.png')).'" class="h-10 w-10 object-contain rounded border border-gray-100 dark:border-gray-700 p-0.5" alt=""><span class="font-medium text-slate-800 dark:text-slate-200">'.e($team->name).'</span></div>',
            e($team->category ?? '-'),
            e($team->season?->name ?? '-'),
        ];
        if (auth()->user()->isSuperAdmin()) {
            $row[] = e($team->club->name);
        }
        $row[] = attex_status_badge_html($team->is_active);
        $row[] = attex_row_actions_html(route('teams.show', $team), route('teams.edit', $team), route('teams.destroy', $team));

        return $row;
    })->values()->all();
@endphp

@include('partials.attex.data-table', [
    'title' => 'Lista de Times',
    'count' => $teams->count(),
    'columns' => $gridColumns,
    'rows' => $gridRows,
])
@endsection