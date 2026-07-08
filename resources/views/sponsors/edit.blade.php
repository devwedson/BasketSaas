@extends('layouts.attex.app')

@section('title', 'Editar '.$sponsor->name)

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Editar Patrocinador',
    'breadcrumbs' => [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Patrocinadores', 'url' => route('sponsors.index')],
        ['label' => $sponsor->name],
    ],
])

@include('partials.attex.form-card-open', [
    'formTitle' => 'Editar Patrocinador',
    'formSubtitle' => $sponsor->name,
    'formAction' => route('sponsors.update', $sponsor),
    'formMethod' => 'PUT',
    'enctype' => 'multipart/form-data',
])
    @include('sponsors._form', ['sponsor' => $sponsor])
@include('partials.attex.form-card-close', ['cancelUrl' => route('sponsors.show', $sponsor), 'submitLabel' => 'Atualizar Patrocinador'])
@endsection