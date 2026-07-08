@extends('layouts.attex.app')

@section('title', 'Editar Jogador')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Editar Jogador',
    'breadcrumbs' => [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Jogadores', 'url' => route('players.index')],
        ['label' => $player->name],
    ],
])

@include('partials.attex.form-card-open', [
    'formTitle' => 'Editar Jogador',
    'formSubtitle' => $player->name,
    'formAction' => route('players.update', $player),
    'formMethod' => 'PUT',
    'enctype' => 'multipart/form-data',
])
    @include('players._form', ['player' => $player])
@include('partials.attex.form-card-close', ['cancelUrl' => route('players.show', $player), 'submitLabel' => 'Atualizar Jogador'])
@endsection