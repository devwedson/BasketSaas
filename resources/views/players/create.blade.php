@extends('layouts.attex.app')

@section('title', 'Novo Jogador')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Novo Jogador',
    'breadcrumbs' => [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Jogadores', 'url' => route('players.index')],
        ['label' => 'Novo'],
    ],
])

@include('partials.attex.form-card-open', [
    'formTitle' => 'Cadastrar Jogador',
    'formSubtitle' => 'Dados do atleta e foto exibida na landing',
    'formAction' => route('players.store'),
    'enctype' => 'multipart/form-data',
])
    @include('players._form')
@include('partials.attex.form-card-close', ['cancelUrl' => route('players.index'), 'submitLabel' => 'Salvar Jogador'])
@endsection