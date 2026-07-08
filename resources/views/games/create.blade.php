@extends('layouts.attex.app')

@section('title', 'Novo Jogo')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Novo Jogo',
    'breadcrumbs' => [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Jogos', 'url' => route('games.index')],
        ['label' => 'Novo'],
    ],
])

@include('partials.attex.form-card-open', [
    'formTitle' => 'Cadastrar Jogo',
    'formSubtitle' => 'Adversário, data, local e imagens para a landing',
    'formAction' => route('games.store'),
    'enctype' => 'multipart/form-data',
])
    @include('games._form', ['game' => null])
@include('partials.attex.form-card-close', ['cancelUrl' => route('games.index'), 'submitLabel' => 'Salvar Jogo'])
@endsection