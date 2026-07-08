@extends('layouts.attex.app')

@section('title', 'Nova Foto de Evento')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Nova Foto',
    'breadcrumbs' => [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Fotos de Eventos', 'url' => route('event-photos.index')],
        ['label' => 'Nova'],
    ],
])

@include('partials.attex.form-card-open', [
    'formTitle' => 'Publicar Foto de Evento',
    'formSubtitle' => 'A imagem aparecerá na galeria da landing',
    'formAction' => route('event-photos.store'),
    'enctype' => 'multipart/form-data',
])
    @include('event-photos._form', ['eventPhoto' => null])
@include('partials.attex.form-card-close', ['cancelUrl' => route('event-photos.index'), 'submitLabel' => 'Publicar Foto'])
@endsection