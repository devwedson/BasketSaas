@extends('layouts.attex.app')

@section('title', 'Clubes')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Clubes',
    'subtitle' => 'Gestão de clubes, logos e imagens da landing',
    'breadcrumbs' => [['label' => 'Dashboard', 'url' => route('dashboard')], ['label' => 'Clubes']],
    'actionUrl' => route('clubs.create'),
    'actionLabel' => 'Novo Clube',
    'actionIcon' => 'ri-add-line',
])

<div class="card">
    <div class="card-header flex justify-between items-center">
        <h4 class="card-title">Lista de Clubes</h4>
        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $clubs->total() }} registro(s)</span>
    </div>
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr>
                        <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Clube</th>
                        <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Cidade</th>
                        <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Contato</th>
                        <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Status</th>
                        <th scope="col" class="px-4 py-4 text-end text-sm font-medium text-gray-500 dark:text-gray-400">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($clubs as $club)
                        <tr>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <img src="{{ club_logo_url($club) }}" alt="{{ $club->name }}" class="h-9 w-9 object-contain rounded border border-gray-100 dark:border-gray-700 p-0.5">
                                    <span class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $club->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $club->city ?? '-' }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $club->email ?? $club->phone ?? '-' }}</td>
                            <td class="px-4 py-4 whitespace-nowrap">@include('partials.attex.status-badge', ['active' => $club->is_active])</td>
                            <td class="px-4 py-4 whitespace-nowrap text-end">
                                @include('partials.attex.row-actions', [
                                    'showUrl' => route('clubs.show', $club),
                                    'editUrl' => route('clubs.edit', $club),
                                    'deleteUrl' => route('clubs.destroy', $club),
                                ])
                            </td>
                        </tr>
                    @empty
                        @include('partials.attex.empty-row', ['colspan' => 5])
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('partials.attex.pagination', ['paginator' => $clubs])
@endsection