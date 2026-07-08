@extends('layouts.attex.app')

@section('title', 'Nova Comissão')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Novo Membro',
    'breadcrumbs' => [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Comissão Técnica', 'url' => route('staff.index')],
        ['label' => 'Novo'],
    ],
])

@include('partials.attex.form-card-open', [
    'formTitle' => 'Cadastrar Membro da Comissão',
    'formSubtitle' => 'Dados e foto exibida na landing',
    'formAction' => route('staff.store'),
    'enctype' => 'multipart/form-data',
])
    @include('staff._form')
@include('partials.attex.form-card-close', ['cancelUrl' => route('staff.index'), 'submitLabel' => 'Salvar Membro'])
@endsection