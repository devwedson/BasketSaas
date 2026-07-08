@extends('layouts.attex.app')

@section('title', 'Patrocinadores')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Patrocinadores',
    'subtitle' => 'Empresas e marcas que apoiam o clube',
    'breadcrumbs' => [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Patrocinadores'],
    ],
    'actionUrl' => route('sponsors.create'),
    'actionLabel' => 'Novo Patrocinador',
    'actionIcon' => 'ri-add-line',
])

@php
    $gridColumns = [
        ['name' => 'Patrocinador', 'html' => true],
        ['name' => 'Nível', 'html' => true],
    ];
    if (auth()->user()->isSuperAdmin()) {
        $gridColumns[] = ['name' => 'Clube'];
    }
    $gridColumns[] = ['name' => 'Contrato'];
    $gridColumns[] = ['name' => 'Landing', 'html' => true];
    $gridColumns[] = ['name' => 'Status', 'html' => true];
    $gridColumns[] = ['name' => 'Ações', 'html' => true, 'sort' => false, 'width' => '150px'];

    $gridRows = $sponsors->map(function ($sponsor, $index) {
        $row = [
            '<div class="flex items-center gap-3">'
                .'<img src="'.e(sponsor_logo_url($sponsor, $index)).'" class="h-9 w-16 object-contain rounded border border-gray-100 dark:border-gray-700 p-0.5 bg-white dark:bg-gray-800" alt="">'
                .'<span class="font-medium text-slate-800 dark:text-slate-200">'.e($sponsor->name).'</span>'
                .'</div>',
            '<span class="inline-flex py-1 px-2 rounded-md text-xs font-medium bg-primary/10 text-primary">'.e($sponsor->tier->label()).'</span>',
        ];
        if (auth()->user()->isSuperAdmin()) {
            $row[] = e($sponsor->club->name);
        }
        $row[] = $sponsor->contract_amount
            ? 'R$ '.number_format($sponsor->contract_amount, 2, ',', '.')
            : '-';
        $row[] = attex_status_badge_html($sponsor->show_on_landing, 'Visível', 'Oculto');
        $row[] = attex_status_badge_html($sponsor->is_active);
        $row[] = attex_row_actions_html(route('sponsors.show', $sponsor), route('sponsors.edit', $sponsor), route('sponsors.destroy', $sponsor));

        return $row;
    })->values()->all();
@endphp

@include('partials.attex.data-table', [
    'title' => 'Lista de Patrocinadores',
    'count' => $sponsors->count(),
    'columns' => $gridColumns,
    'rows' => $gridRows,
])
@endsection