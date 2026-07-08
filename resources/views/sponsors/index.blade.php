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

<div class="card">
    <div class="card-header flex justify-between items-center">
        <h4 class="card-title">Lista de Patrocinadores</h4>
        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $sponsors->total() }} registro(s)</span>
    </div>
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr>
                        <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Patrocinador</th>
                        <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Nível</th>
                        @if (auth()->user()->isSuperAdmin())
                            <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Clube</th>
                        @endif
                        <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Contrato</th>
                        <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Landing</th>
                        <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Status</th>
                        <th scope="col" class="px-4 py-4 text-end text-sm font-medium text-gray-500 dark:text-gray-400">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($sponsors as $sponsor)
                        <tr>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <img src="{{ sponsor_logo_url($sponsor, $loop->index) }}" alt="{{ $sponsor->name }}" class="h-9 w-16 object-contain rounded border border-gray-100 dark:border-gray-700 p-0.5 bg-white dark:bg-gray-800">
                                    <span class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $sponsor->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="inline-flex py-1 px-2 rounded-md text-xs font-medium bg-primary/10 text-primary">{{ $sponsor->tier->label() }}</span>
                            </td>
                            @if (auth()->user()->isSuperAdmin())
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $sponsor->club->name }}</td>
                            @endif
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                @if ($sponsor->contract_amount)
                                    R$ {{ number_format($sponsor->contract_amount, 2, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                @include('partials.attex.status-badge', [
                                    'active' => $sponsor->show_on_landing,
                                    'activeLabel' => 'Visível',
                                    'inactiveLabel' => 'Oculto',
                                ])
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">@include('partials.attex.status-badge', ['active' => $sponsor->is_active])</td>
                            <td class="px-4 py-4 whitespace-nowrap text-end">
                                @include('partials.attex.row-actions', [
                                    'showUrl' => route('sponsors.show', $sponsor),
                                    'editUrl' => route('sponsors.edit', $sponsor),
                                    'deleteUrl' => route('sponsors.destroy', $sponsor),
                                ])
                            </td>
                        </tr>
                    @empty
                        @include('partials.attex.empty-row', ['colspan' => auth()->user()->isSuperAdmin() ? 7 : 6, 'message' => 'Nenhum patrocinador cadastrado.'])
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('partials.attex.pagination', ['paginator' => $sponsors])
@endsection