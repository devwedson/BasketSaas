@extends('layouts.attex.app')

@section('title', 'Novo Patrocinador')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Novo Patrocinador',
    'breadcrumbs' => [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Patrocinadores', 'url' => route('sponsors.index')],
        ['label' => 'Novo'],
    ],
])

@include('partials.attex.form-card-open', [
    'formTitle' => 'Cadastrar Patrocinador',
    'formSubtitle' => 'Dados da empresa e exibição na landing',
    'formAction' => route('sponsors.store'),
    'enctype' => 'multipart/form-data',
])
    @include('sponsors._form', ['sponsor' => null])
@include('partials.attex.form-card-close', ['cancelUrl' => route('sponsors.index'), 'submitLabel' => 'Salvar Patrocinador'])
@endsection