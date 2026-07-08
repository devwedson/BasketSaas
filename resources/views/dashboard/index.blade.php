@extends('layouts.attex.app')

@section('title', 'Dashboard')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Dashboard',
    'subtitle' => 'Visão geral da gestão do basquete',
    'breadcrumbs' => [
        ['label' => config('app.name')],
        ['label' => 'Dashboard'],
    ],
])

<div class="grid 2xl:grid-cols-5 lg:grid-cols-3 md:grid-cols-2 gap-6 mb-6">
    @if (auth()->user()->isSuperAdmin())
        @include('partials.attex.stat-card', ['label' => 'Clubes', 'value' => $stats['clubs'], 'icon' => 'ri-building-2-line'])
    @endif
    @include('partials.attex.stat-card', ['label' => 'Times', 'value' => $stats['teams'], 'icon' => 'ri-team-line'])
    @include('partials.attex.stat-card', ['label' => 'Atletas Ativos', 'value' => $stats['players'], 'icon' => 'ri-user-star-line'])
    @include('partials.attex.stat-card', ['label' => 'Próximos Treinos', 'value' => $stats['trainings'], 'icon' => 'ri-basketball-line'])
    @include('partials.attex.stat-card', ['label' => 'Próximos Jogos', 'value' => $stats['games'], 'icon' => 'ri-trophy-line'])
</div>

@if ($inscriptionPayment)
<div class="card mb-6 border border-success/20">
    <div class="card-header flex justify-between items-center">
        <h4 class="card-title">Inscrição paga</h4>
        <span class="text-xs font-medium text-success">Confirmada</span>
    </div>
    <div class="p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Pagamento de R$ {{ number_format($inscriptionPayment->amount, 2, ',', '.') }} em {{ $inscriptionPayment->paid_at?->format('d/m/Y H:i') ?? '—' }}</p>
            <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">Seu comprovante fica disponível aqui para consulta a qualquer momento.</p>
        </div>
        <a href="{{ route('inscription.payments.receipt', $inscriptionPayment) }}" target="_blank" rel="noopener" class="btn btn-sm bg-success text-white">
            <i class="ri-file-pdf-line me-1"></i> Ver comprovante
        </a>
    </div>
</div>
@endif

<div class="card mb-6">
    <div class="card-header flex justify-between items-center">
        <h4 class="card-title">Acesso Rápido</h4>
    </div>
    <div class="p-6">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('teams.create') }}" class="btn btn-sm bg-primary text-white"><i class="ri-team-line me-1"></i> Novo Time</a>
            <a href="{{ route('players.create') }}" class="btn btn-sm bg-info text-white"><i class="ri-user-add-line me-1"></i> Novo Jogador</a>
            <a href="{{ route('trainings.create') }}" class="btn btn-sm bg-success text-white"><i class="ri-calendar-event-line me-1"></i> Novo Treino</a>
            <a href="{{ route('games.create') }}" class="btn btn-sm bg-warning text-white"><i class="ri-trophy-line me-1"></i> Novo Jogo</a>
            <a href="{{ route('calendar.index') }}" class="btn btn-sm bg-light text-dark dark:bg-gray-700 dark:text-gray-200"><i class="ri-calendar-line me-1"></i> Calendário</a>
            <a href="{{ route('reports.index') }}" class="btn btn-sm bg-light text-dark dark:bg-gray-700 dark:text-gray-200"><i class="ri-file-chart-line me-1"></i> Relatórios</a>
            @if (auth()->user()->isSuperAdmin())
                <a href="{{ route('landing.settings.edit') }}" class="btn btn-sm bg-primary text-white"><i class="ri-global-line me-1"></i> Landing</a>
                <a href="{{ route('smtp.settings.edit') }}" class="btn btn-sm bg-secondary text-white"><i class="ri-mail-settings-line me-1"></i> SMTP</a>
            @endif
        </div>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-6">
    <div class="card">
        <div class="card-header flex justify-between items-center">
            <h4 class="card-title">Próximos Treinos</h4>
            <a href="{{ route('trainings.index') }}" class="btn btn-sm bg-light text-dark dark:bg-gray-700 dark:text-gray-200">Ver todos</a>
        </div>
        <div class="p-6 pt-0">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr>
                            <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Treino</th>
                            <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Local</th>
                            <th scope="col" class="px-4 py-4 text-end text-sm font-medium text-gray-500 dark:text-gray-400">Data</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($upcomingTrainings as $training)
                            <tr>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">
                                    <a href="{{ route('trainings.show', $training) }}" class="hover:text-primary">{{ $training->title }}</a>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $training->location ?? 'A definir' }}</td>
                                <td class="px-4 py-4 text-end whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $training->scheduled_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            @include('partials.attex.empty-row', ['colspan' => 3, 'message' => 'Nenhum treino agendado.'])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header flex justify-between items-center">
            <h4 class="card-title">Próximos Jogos</h4>
            <a href="{{ route('games.index') }}" class="btn btn-sm bg-light text-dark dark:bg-gray-700 dark:text-gray-200">Ver todos</a>
        </div>
        <div class="p-6 pt-0">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr>
                            <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Confronto</th>
                            <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Local</th>
                            <th scope="col" class="px-4 py-4 text-end text-sm font-medium text-gray-500 dark:text-gray-400">Data</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($upcomingGames as $game)
                            <tr>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">
                                    <a href="{{ route('games.show', $game) }}" class="hover:text-primary">vs {{ $game->opponent }}</a>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $game->location ?? 'A definir' }}</td>
                                <td class="px-4 py-4 text-end whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $game->scheduled_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            @include('partials.attex.empty-row', ['colspan' => 3, 'message' => 'Nenhum jogo agendado.'])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection