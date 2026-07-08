@extends('layouts.attex.app')

@section('title', $staff->name)

@section('content')
@include('partials.attex.show-header', [
    'title' => $staff->name,
    'subtitle' => $staff->role->label(),
    'media' => '<img src="'.e(staff_photo_url($staff)).'" alt="'.e($staff->name).'" class="h-16 w-16 rounded-full object-cover border border-gray-200 dark:border-gray-700">',
    'editUrl' => route('staff.edit', $staff),
    'backUrl' => route('staff.index'),
])

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Detalhes do Membro</h4>
    </div>
    <div class="p-6">
        <dl class="grid md:grid-cols-2 gap-6">
            @include('partials.attex.detail-item', ['label' => 'Time', 'value' => $staff->team?->name])
            @include('partials.attex.detail-item', ['label' => 'Clube', 'value' => $staff->club->name])
            @include('partials.attex.detail-item', ['label' => 'Função', 'value' => $staff->role->label()])
            @include('partials.attex.detail-item', ['label' => 'E-mail', 'value' => $staff->email])
            @include('partials.attex.detail-item', ['label' => 'Telefone', 'value' => $staff->phone])
            @include('partials.attex.detail-item', ['label' => 'Status', 'value' => $staff->is_active ? 'Ativo' : 'Inativo'])
        </dl>
    </div>
</div>
@endsection