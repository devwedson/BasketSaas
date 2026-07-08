@extends('layouts.attex.app')

@section('title', 'Editar Jogo')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Editar Jogo',
    'breadcrumbs' => [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Jogos', 'url' => route('games.index')],
        ['label' => 'vs '.$game->opponent],
    ],
])

@include('partials.attex.form-card-open', [
    'formTitle' => 'Editar Jogo',
    'formSubtitle' => 'vs '.$game->opponent,
    'formAction' => route('games.update', $game),
    'formMethod' => 'PUT',
    'enctype' => 'multipart/form-data',
])
    @include('games._form', ['game' => $game])
@include('partials.attex.form-card-close', ['cancelUrl' => route('games.show', $game), 'submitLabel' => 'Atualizar Jogo'])
@endsection