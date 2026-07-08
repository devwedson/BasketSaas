@extends('layouts.attex.app')

@section('title', 'Novo Clube')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Novo Clube',
    'breadcrumbs' => [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Clubes', 'url' => route('clubs.index')],
        ['label' => 'Novo'],
    ],
])

@include('partials.attex.form-card-open', [
    'formTitle' => 'Cadastrar Clube',
    'formSubtitle' => 'Dados institucionais e imagens da landing',
    'formAction' => route('clubs.store'),
    'enctype' => 'multipart/form-data',
])
    @include('clubs._form', ['club' => null])
@include('partials.attex.form-card-close', ['cancelUrl' => route('clubs.index'), 'submitLabel' => 'Salvar Clube'])
@endsection