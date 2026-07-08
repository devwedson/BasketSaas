@extends('layouts.attex.app')

@section('title', 'Editar Treino')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Editar Treino',
    'breadcrumbs' => [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Treinos', 'url' => route('trainings.index')],
        ['label' => $training->title],
    ],
])

@include('partials.attex.form-card-open', [
    'formTitle' => 'Editar Treino',
    'formSubtitle' => $training->title,
    'formAction' => route('trainings.update', $training),
    'formMethod' => 'PUT',
])
    @include('trainings._form', ['training' => $training])
@include('partials.attex.form-card-close', ['cancelUrl' => route('trainings.show', $training), 'submitLabel' => 'Atualizar Treino'])
@endsection