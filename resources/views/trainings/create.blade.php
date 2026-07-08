@extends('layouts.attex.app')

@section('title', 'Novo Treino')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Novo Treino',
    'breadcrumbs' => [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Treinos', 'url' => route('trainings.index')],
        ['label' => 'Novo'],
    ],
])

@include('partials.attex.form-card-open', [
    'formTitle' => 'Cadastrar Treino',
    'formSubtitle' => 'Data, local, exercícios e observações',
    'formAction' => route('trainings.store'),
])
    @include('trainings._form', ['training' => null])
@include('partials.attex.form-card-close', ['cancelUrl' => route('trainings.index'), 'submitLabel' => 'Salvar Treino'])
@endsection