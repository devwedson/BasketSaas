@extends('layouts.attex.app')

@section('title', 'vs '.$game->opponent)

@section('content')
@include('partials.attex.show-header', [
    'title' => 'vs '.$game->opponent,
    'subtitle' => $game->scheduled_at->format('d/m/Y H:i').' · '.($game->is_home ? 'Casa' : 'Fora'),
    'editUrl' => route('games.edit', $game),
    'backUrl' => route('games.index'),
    'actionsView' => 'games.partials.export-actions',
    'actionsData' => ['game' => $game],
])

<div class="grid md:grid-cols-3 gap-6 mb-6">
    @include('partials.attex.stat-card', ['label' => 'Placar', 'value' => isset($game->home_score) ? $game->home_score.' x '.$game->away_score : 'A definir', 'icon' => 'ri-trophy-line'])
    @include('partials.attex.stat-card', ['label' => 'Local', 'value' => $game->location ?? 'A definir', 'icon' => 'ri-map-pin-line'])
    @include('partials.attex.stat-card', ['label' => 'Time', 'value' => $game->team?->name ?? '-', 'icon' => 'ri-team-line'])
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Estatísticas dos Jogadores</h4>
    </div>
    <div class="p-6">
        <form method="POST" action="{{ route('games.stats', $game) }}">
            @csrf
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr>
                            <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Jogador</th>
                            <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">MIN</th>
                            <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">PTS</th>
                            <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">REB</th>
                            <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">AST</th>
                            <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">ROU</th>
                            <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">TOC</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($players as $player)
                            @php $s = $game->stats->firstWhere('player_id', $player->id); @endphp
                            <tr>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">{{ $player->name }}</td>
                                <td class="px-4 py-4 whitespace-nowrap"><input type="number" name="stats[{{ $player->id }}][minutes]" class="form-input w-20" min="0" value="{{ $s?->minutes ?? 0 }}"></td>
                                <td class="px-4 py-4 whitespace-nowrap"><input type="number" name="stats[{{ $player->id }}][points]" class="form-input w-20" min="0" value="{{ $s?->points ?? 0 }}"></td>
                                <td class="px-4 py-4 whitespace-nowrap"><input type="number" name="stats[{{ $player->id }}][rebounds]" class="form-input w-20" min="0" value="{{ $s?->rebounds ?? 0 }}"></td>
                                <td class="px-4 py-4 whitespace-nowrap"><input type="number" name="stats[{{ $player->id }}][assists]" class="form-input w-20" min="0" value="{{ $s?->assists ?? 0 }}"></td>
                                <td class="px-4 py-4 whitespace-nowrap"><input type="number" name="stats[{{ $player->id }}][steals]" class="form-input w-20" min="0" value="{{ $s?->steals ?? 0 }}"></td>
                                <td class="px-4 py-4 whitespace-nowrap"><input type="number" name="stats[{{ $player->id }}][blocks]" class="form-input w-20" min="0" value="{{ $s?->blocks ?? 0 }}"></td>
                            </tr>
                        @empty
                            @include('partials.attex.empty-row', ['colspan' => 7, 'message' => 'Nenhum jogador disponível.'])
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($players->isNotEmpty())
                <div class="flex gap-2 pt-6 mt-6 border-t border-gray-100 dark:border-gray-700">
                    <button type="submit" class="btn bg-primary text-white"><i class="ri-save-line me-1"></i> Salvar Estatísticas</button>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection