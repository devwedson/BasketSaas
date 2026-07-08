@extends('layouts.attex.app')

@section('title', 'Jogadores')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Jogadores',
    'subtitle' => 'Cadastro de atletas e fotos para a landing',
    'breadcrumbs' => [['label' => 'Dashboard', 'url' => route('dashboard')], ['label' => 'Jogadores']],
    'actionUrl' => route('players.create'),
    'actionLabel' => 'Novo Jogador',
    'actionIcon' => 'ri-add-line',
])

<div class="card">
    <div class="card-header flex justify-between items-center">
        <h4 class="card-title">Lista de Jogadores</h4>
        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $players->total() }} registro(s)</span>
    </div>
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr>
                        <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Atleta</th>
                        <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Nº</th>
                        <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Posição</th>
                        <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Time</th>
                        <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Status</th>
                        <th scope="col" class="px-4 py-4 text-end text-sm font-medium text-gray-500 dark:text-gray-400">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($players as $player)
                        <tr>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <img src="{{ player_photo_url($player) }}" alt="{{ $player->name }}" class="h-9 w-9 rounded-full object-cover border border-gray-100 dark:border-gray-700">
                                    <span class="text-sm font-medium text-gray-800 dark:text-gray-200">{{ $player->name }}</span>
                                </div>
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $player->number ?? '-' }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $player->position?->label() ?? '-' }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $player->team?->name ?? '-' }}</td>
                            <td class="px-4 py-4 whitespace-nowrap">@include('partials.attex.status-badge', ['active' => $player->is_active])</td>
                            <td class="px-4 py-4 whitespace-nowrap text-end">
                                @include('partials.attex.row-actions', [
                                    'showUrl' => route('players.show', $player),
                                    'editUrl' => route('players.edit', $player),
                                    'deleteUrl' => route('players.destroy', $player),
                                ])
                            </td>
                        </tr>
                    @empty
                        @include('partials.attex.empty-row', ['colspan' => 6])
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('partials.attex.pagination', ['paginator' => $players])
@endsection