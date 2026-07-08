@extends('layouts.attex.app')

@section('title', 'Treinos')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Treinos',
    'subtitle' => 'Agenda de treinos e presença dos atletas',
    'breadcrumbs' => [['label' => 'Dashboard', 'url' => route('dashboard')], ['label' => 'Treinos']],
    'actionUrl' => route('trainings.create'),
    'actionLabel' => 'Novo Treino',
    'actionIcon' => 'ri-add-line',
])

@php
    $gridColumns = [
        ['name' => 'Título'],
        ['name' => 'Data/Hora'],
        ['name' => 'Local'],
        ['name' => 'Time'],
        ['name' => 'Ações', 'html' => true, 'sort' => false, 'width' => '150px'],
    ];
    $gridRows = $trainings->map(fn ($training) => [
        e($training->title),
        e($training->scheduled_at->format('d/m/Y H:i')),
        e($training->location ?? '-'),
        e($training->team?->name ?? '-'),
        attex_row_actions_html(route('trainings.show', $training), route('trainings.edit', $training), route('trainings.destroy', $training)),
    ])->values()->all();
@endphp

@include('partials.attex.data-table', [
    'title' => 'Lista de Treinos',
    'count' => $trainings->count(),
    'columns' => $gridColumns,
    'rows' => $gridRows,
])
@endsection