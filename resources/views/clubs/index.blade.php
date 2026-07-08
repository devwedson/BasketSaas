@extends('layouts.attex.app')

@section('title', 'Clubes')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Clubes',
    'subtitle' => 'Gestão de clubes, logos e imagens da landing',
    'breadcrumbs' => [['label' => 'Dashboard', 'url' => route('dashboard')], ['label' => 'Clubes']],
    'actionUrl' => route('clubs.create'),
    'actionLabel' => 'Novo Clube',
    'actionIcon' => 'ri-add-line',
])

@php
    $gridColumns = [
        ['name' => 'Clube', 'html' => true],
        ['name' => 'Cidade'],
        ['name' => 'Contato'],
        ['name' => 'Status', 'html' => true],
        ['name' => 'Ações', 'html' => true, 'sort' => false, 'width' => '150px'],
    ];
    $gridRows = $clubs->map(fn ($club) => [
        '<div class="flex items-center gap-3"><img src="'.e(club_logo_url($club)).'" class="h-9 w-9 object-contain rounded border border-gray-100 dark:border-gray-700 p-0.5" alt=""><span class="font-medium text-slate-800 dark:text-slate-200">'.e($club->name).'</span></div>',
        e($club->city ?? '-'),
        e($club->email ?? $club->phone ?? '-'),
        attex_status_badge_html($club->is_active),
        attex_row_actions_html(route('clubs.show', $club), route('clubs.edit', $club), route('clubs.destroy', $club)),
    ])->values()->all();
@endphp

@include('partials.attex.data-table', [
    'title' => 'Lista de Clubes',
    'count' => $clubs->count(),
    'columns' => $gridColumns,
    'rows' => $gridRows,
])
@endsection