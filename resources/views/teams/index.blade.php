@extends('layouts.attex.app')

@section('title', 'Times')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Times',
    'subtitle' => 'Gerencie categorias, logos e elencos',
    'breadcrumbs' => [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Times'],
    ],
    'actionUrl' => route('teams.create'),
    'actionLabel' => 'Novo Time',
    'actionIcon' => 'ri-add-line',
])

<div class="card">
    <div class="card-header flex justify-between items-center">
        <h4 class="card-title">Lista de Times</h4>
        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $teams->total() }} registro(s)</span>
    </div>
    <div class="p-6">
        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Time</th>
                                <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Categoria</th>
                                <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Temporada</th>
                                @if (auth()->user()->isSuperAdmin())
                                    <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Clube</th>
                                @endif
                                <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Status</th>
                                <th scope="col" class="px-4 py-4 text-end text-sm font-medium text-gray-500 dark:text-gray-400">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($teams as $team)
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ team_logo_url($team, 'images/team-logo-1.png') }}" alt="{{ $team->name }}" class="h-10 w-10 object-contain rounded border border-gray-100 dark:border-gray-700 p-0.5">
                                            <span class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $team->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 dark:text-gray-300">{{ $team->category ?? '-' }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 dark:text-gray-300">{{ $team->season?->name ?? '-' }}</td>
                                    @if (auth()->user()->isSuperAdmin())
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 dark:text-gray-300">{{ $team->club->name }}</td>
                                    @endif
                                    <td class="px-4 py-4 whitespace-nowrap">@include('partials.attex.status-badge', ['active' => $team->is_active])</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-end">
                                        @include('partials.attex.row-actions', [
                                            'showUrl' => route('teams.show', $team),
                                            'editUrl' => route('teams.edit', $team),
                                            'deleteUrl' => route('teams.destroy', $team),
                                        ])
                                    </td>
                                </tr>
                            @empty
                                @include('partials.attex.empty-row', ['colspan' => auth()->user()->isSuperAdmin() ? 6 : 5, 'message' => 'Nenhum time cadastrado.'])
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.attex.pagination', ['paginator' => $teams])
@endsection