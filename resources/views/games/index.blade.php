@extends('layouts.attex.app')

@section('title', 'Jogos')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Jogos',
    'subtitle' => 'Calendário, placares, logos e capas para a landing',
    'breadcrumbs' => [['label' => 'Dashboard', 'url' => route('dashboard')], ['label' => 'Jogos']],
    'actionUrl' => route('games.create'),
    'actionLabel' => 'Novo Jogo',
    'actionIcon' => 'ri-add-line',
])

<div class="card">
    <div class="card-header flex justify-between items-center">
        <h4 class="card-title">Lista de Jogos</h4>
        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $games->total() }} registro(s)</span>
    </div>
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr>
                        <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Confronto</th>
                        <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Data/Hora</th>
                        <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Placar</th>
                        <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Time</th>
                        <th scope="col" class="px-4 py-4 text-end text-sm font-medium text-gray-500 dark:text-gray-400">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($games as $game)
                        <tr>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <img src="{{ team_logo_url($game->team, 'images/team-logo-1.png') }}" alt="" class="h-8 w-8 object-contain">
                                    <span class="text-gray-400 dark:text-gray-500">vs</span>
                                    <img src="{{ game_opponent_logo_url($game) }}" alt="" class="h-8 w-8 object-contain">
                                    <span class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $game->opponent }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $game->scheduled_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                @if ($game->home_score !== null)
                                    <span class="inline-flex py-1 px-2 rounded-md bg-primary/10 text-primary text-xs font-medium">{{ $game->home_score }} x {{ $game->away_score }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $game->team?->name ?? '-' }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-end">
                                @include('partials.attex.row-actions', [
                                    'showUrl' => route('games.show', $game),
                                    'editUrl' => route('games.edit', $game),
                                    'deleteUrl' => route('games.destroy', $game),
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

@include('partials.attex.pagination', ['paginator' => $games])
@endsection