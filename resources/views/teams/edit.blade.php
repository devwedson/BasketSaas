@extends('layouts.attex.app')

@section('title', 'Editar Time')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Editar Time',
    'breadcrumbs' => [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Times', 'url' => route('teams.index')],
        ['label' => $team->name],
    ],
])

@include('partials.attex.form-card-open', [
    'formTitle' => 'Editar Time',
    'formSubtitle' => $team->name,
    'formAction' => route('teams.update', $team),
    'formMethod' => 'PUT',
    'enctype' => 'multipart/form-data',
])
    @include('teams._form', ['team' => $team])
@include('partials.attex.form-card-close', ['cancelUrl' => route('teams.show', $team), 'submitLabel' => 'Atualizar Time'])
@endsection