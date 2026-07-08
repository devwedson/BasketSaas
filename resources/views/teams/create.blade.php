@extends('layouts.attex.app')

@section('title', 'Novo Time')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Novo Time',
    'breadcrumbs' => [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Times', 'url' => route('teams.index')],
        ['label' => 'Novo'],
    ],
])

@include('partials.attex.form-card-open', [
    'formTitle' => 'Cadastrar Time',
    'formSubtitle' => 'Informe dados, logo e imagem de capa para a landing',
    'formAction' => route('teams.store'),
    'enctype' => 'multipart/form-data',
])
    @include('teams._form')
@include('partials.attex.form-card-close', ['cancelUrl' => route('teams.index'), 'submitLabel' => 'Salvar Time'])
@endsection