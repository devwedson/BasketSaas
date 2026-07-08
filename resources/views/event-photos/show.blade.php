@extends('layouts.attex.app')

@section('title', $eventPhoto->title)

@section('content')
@include('partials.attex.page-header', [
    'title' => $eventPhoto->title,
    'breadcrumbs' => [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Fotos de Eventos', 'url' => route('event-photos.index')],
        ['label' => $eventPhoto->title],
    ],
    'actionUrl' => route('event-photos.edit', $eventPhoto),
    'actionLabel' => 'Editar',
    'actionIcon' => 'ri-pencil-line',
])

<div class="card">
    <div class="p-6">
        <div class="mb-6">
            <img src="{{ event_photo_url($eventPhoto) }}" alt="{{ $eventPhoto->title }}" class="max-h-80 w-full object-cover rounded-lg border border-gray-200 dark:border-gray-700">
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            @include('partials.attex.detail-item', ['label' => 'Clube', 'value' => $eventPhoto->club->name])
            @include('partials.attex.detail-item', ['label' => 'Data do evento', 'value' => $eventPhoto->event_date?->format('d/m/Y') ?? '—'])
            @include('partials.attex.detail-item', ['label' => 'Ordem', 'value' => (string) $eventPhoto->sort_order])
            @include('partials.attex.detail-item', ['label' => 'Status', 'value' => $eventPhoto->is_active ? 'Visível na landing' : 'Oculta'])
            @if ($eventPhoto->description)
                <div class="md:col-span-2">
                    @include('partials.attex.detail-item', ['label' => 'Descrição', 'value' => $eventPhoto->description])
                </div>
            @endif
        </div>
    </div>
</div>
@endsection