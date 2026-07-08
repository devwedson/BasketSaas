@extends('layouts.attex.app')

@section('title', 'Relatórios')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Relatórios',
    'subtitle' => 'Exporte dados em PDF ou Excel',
    'breadcrumbs' => [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Relatórios'],
    ],
])

<div class="card mb-6">
    <div class="card-header">
        <h4 class="card-title">Filtros</h4>
    </div>
    <div class="p-6">
        <form method="GET" action="{{ route('reports.index') }}" class="grid md:grid-cols-3 gap-4 items-end">
            @if (auth()->user()->isSuperAdmin())
                <div>
                    <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Filtrar por Clube</label>
                    <select name="club_id" class="form-select" onchange="this.form.submit()">
                        <option value="">Todos</option>
                        @foreach ($clubs as $club)
                            <option value="{{ $club->id }}" @selected($selectedClubId == $club->id)>{{ $club->name }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
            <div>
                <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Filtrar por Time</label>
                <select name="team_id" class="form-select" id="filter-team">
                    <option value="">Todos</option>
                    @foreach ($teams as $team)
                        <option value="{{ $team->id }}" @selected(request('team_id') == $team->id)>{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
</div>

<div class="grid md:grid-cols-2 gap-6 mb-6">
    @foreach (collect(config('reports.types'))->filter(fn ($report) => in_array(auth()->user()->role->value, $report['roles'], true)) as $report)
        <div class="card">
            <div class="p-6">
                <div class="flex items-start gap-4 mb-4">
                    <span class="flex items-center justify-center h-12 w-12 rounded-md bg-primary/10 text-primary shrink-0">
                        <i class="{{ $report['icon'] }} text-xl"></i>
                    </span>
                    <div>
                        <h5 class="font-medium text-gray-800 dark:text-gray-200">{{ $report['name'] }}</h5>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $report['description'] }}</p>
                    </div>
                </div>
                <div class="flex gap-2 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <a href="{{ route('reports.export', ['type' => $report['type'], 'format' => 'pdf', 'club_id' => $selectedClubId, 'team_id' => request('team_id')]) }}"
                       class="btn bg-danger text-white btn-sm report-link" data-type="{{ $report['type'] }}">
                        <i class="ri-file-pdf-line me-1"></i> PDF
                    </a>
                    <a href="{{ route('reports.export', ['type' => $report['type'], 'format' => 'excel', 'club_id' => $selectedClubId, 'team_id' => request('team_id')]) }}"
                       class="btn bg-success text-white btn-sm report-link" data-type="{{ $report['type'] }}">
                        <i class="ri-file-excel-line me-1"></i> Excel
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Estatísticas por Jogo</h4>
    </div>
    <div class="p-6">
        <form id="game-stats-form" class="grid md:grid-cols-3 gap-4 items-end">
            <div class="md:col-span-2">
                <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Selecione o Jogo</label>
                <select name="game_id" class="form-select" required>
                    <option value="">Selecione um jogo</option>
                    @foreach ($games as $game)
                        <option value="{{ $game->id }}">
                            vs {{ $game->opponent }} — {{ $game->scheduled_at->format('d/m/Y H:i') }}
                            @if ($game->team) ({{ $game->team->name }}) @endif
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="button" data-format="pdf" class="btn bg-danger text-white game-stats-export">
                    <i class="ri-file-pdf-line me-1"></i> PDF
                </button>
                <button type="button" data-format="excel" class="btn bg-success text-white game-stats-export">
                    <i class="ri-file-excel-line me-1"></i> Excel
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const teamFilter = document.getElementById('filter-team');
    if (teamFilter) {
        teamFilter.addEventListener('change', () => {
            const teamId = teamFilter.value;
            document.querySelectorAll('.report-link').forEach(link => {
                const url = new URL(link.href);
                if (teamId) url.searchParams.set('team_id', teamId);
                else url.searchParams.delete('team_id');
                link.href = url.toString();
            });
        });
    }

    const gameStatsUrls = {
        pdf: @json(route('reports.export', ['type' => 'game-stats', 'format' => 'pdf'])),
        excel: @json(route('reports.export', ['type' => 'game-stats', 'format' => 'excel'])),
    };

    document.querySelectorAll('.game-stats-export').forEach(btn => {
        btn.addEventListener('click', () => {
            const gameId = document.querySelector('[name=game_id]').value;
            if (!gameId) { alert('Selecione um jogo.'); return; }
            const format = btn.dataset.format;
            window.location.href = `${gameStatsUrls[format]}?game_id=${gameId}`;
        });
    });
</script>
@endpush