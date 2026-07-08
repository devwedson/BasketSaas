@extends('layouts.attex.app')

@section('title', 'Editar Comissão')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Editar Membro',
    'breadcrumbs' => [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Comissão Técnica', 'url' => route('staff.index')],
        ['label' => $staff->name],
    ],
])

@include('partials.attex.form-card-open', [
    'formTitle' => 'Editar Membro da Comissão',
    'formSubtitle' => $staff->name,
    'formAction' => route('staff.update', $staff),
    'formMethod' => 'PUT',
    'enctype' => 'multipart/form-data',
])
    @include('staff._form', ['staff' => $staff])
@include('partials.attex.form-card-close', ['cancelUrl' => route('staff.show', $staff), 'submitLabel' => 'Atualizar Membro'])
@endsection