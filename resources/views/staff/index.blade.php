@extends('layouts.attex.app')

@section('title', 'Comissão Técnica')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Comissão Técnica',
    'subtitle' => 'Técnicos, auxiliares e equipe multidisciplinar',
    'breadcrumbs' => [['label' => 'Dashboard', 'url' => route('dashboard')], ['label' => 'Comissão']],
    'actionUrl' => route('staff.create'),
    'actionLabel' => 'Novo Membro',
    'actionIcon' => 'ri-add-line',
])

@php
    $gridColumns = [
        ['name' => 'Profissional', 'html' => true],
        ['name' => 'Função'],
        ['name' => 'Time'],
        ['name' => 'Status', 'html' => true],
        ['name' => 'Ações', 'html' => true, 'sort' => false, 'width' => '150px'],
    ];
    $gridRows = $staffMembers->map(fn ($member) => [
        '<div class="flex items-center gap-3"><img src="'.e(staff_photo_url($member)).'" class="h-9 w-9 rounded-full object-cover border border-gray-100 dark:border-gray-700" alt=""><span class="font-medium text-slate-800 dark:text-slate-200">'.e($member->name).'</span></div>',
        e($member->role->label()),
        e($member->team?->name ?? '-'),
        attex_status_badge_html($member->is_active),
        attex_row_actions_html(route('staff.show', $member), route('staff.edit', $member), route('staff.destroy', $member)),
    ])->values()->all();
@endphp

@include('partials.attex.data-table', [
    'title' => 'Lista da Comissão',
    'count' => $staffMembers->count(),
    'columns' => $gridColumns,
    'rows' => $gridRows,
])
@endsection