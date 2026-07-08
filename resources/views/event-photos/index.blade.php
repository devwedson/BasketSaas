@extends('layouts.attex.app')

@section('title', 'Fotos de Eventos')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Fotos de Eventos',
    'subtitle' => 'Galeria exibida na landing — apenas administradores podem enviar',
    'breadcrumbs' => [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Fotos de Eventos'],
    ],
    'actionUrl' => route('event-photos.create'),
    'actionLabel' => 'Nova Foto',
    'actionIcon' => 'ri-add-line',
])

@php
    $gridColumns = [
        ['name' => 'Foto', 'html' => true],
        ['name' => 'Evento'],
        ['name' => 'Clube'],
        ['name' => 'Data'],
        ['name' => 'Status', 'html' => true],
        ['name' => 'Ações', 'html' => true, 'sort' => false, 'width' => '150px'],
    ];

    $gridRows = $eventPhotos->map(function ($photo) {
        return [
            '<img src="'.e(event_photo_url($photo)).'" class="h-14 w-20 object-cover rounded border border-gray-100 dark:border-gray-700" alt="">',
            e($photo->title),
            e($photo->club->name),
            $photo->event_date?->format('d/m/Y') ?? '-',
            attex_status_badge_html($photo->is_active),
            attex_row_actions_html(route('event-photos.show', $photo), route('event-photos.edit', $photo), route('event-photos.destroy', $photo)),
        ];
    })->values()->all();
@endphp

@include('partials.attex.data-table', [
    'title' => 'Galeria de Eventos',
    'count' => $eventPhotos->count(),
    'columns' => $gridColumns,
    'rows' => $gridRows,
])
@endsection