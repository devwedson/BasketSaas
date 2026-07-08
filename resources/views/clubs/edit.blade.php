@extends('layouts.attex.app')

@section('title', 'Editar Clube')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Editar Clube',
    'breadcrumbs' => [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Clubes', 'url' => route('clubs.index')],
        ['label' => $club->name],
    ],
])

@include('partials.attex.form-card-open', [
    'formTitle' => 'Editar Clube',
    'formSubtitle' => $club->name,
    'formAction' => route('clubs.update', $club),
    'formMethod' => 'PUT',
    'enctype' => 'multipart/form-data',
])
    @include('clubs._form', ['club' => $club])
@include('partials.attex.form-card-close', ['cancelUrl' => route('clubs.show', $club), 'submitLabel' => 'Atualizar Clube'])
@endsection