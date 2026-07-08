@extends('layouts.attex.app')

@section('title', 'Editar Foto de Evento')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Editar Foto',
    'breadcrumbs' => [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Fotos de Eventos', 'url' => route('event-photos.index')],
        ['label' => $eventPhoto->title],
    ],
])

@include('partials.attex.form-card-open', [
    'formTitle' => 'Editar Foto de Evento',
    'formAction' => route('event-photos.update', $eventPhoto),
    'formMethod' => 'PUT',
    'enctype' => 'multipart/form-data',
])
    @include('event-photos._form', ['eventPhoto' => $eventPhoto])
@include('partials.attex.form-card-close', ['cancelUrl' => route('event-photos.show', $eventPhoto), 'submitLabel' => 'Salvar Alterações'])
@endsection