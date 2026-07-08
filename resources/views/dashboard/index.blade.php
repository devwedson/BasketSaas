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

<div class="grid 2xl:grid-cols-5 lg:grid-cols-6 md:grid-cols-2 gap-6 mb-6">
    @if (auth()->user()->isSuperAdmin())
        <div class="2xl:col-span-1 lg:col-span-2">
            @include('partials.attex.stat-card', ['label' => 'Clubes', 'value' => $stats['clubs'], 'icon' => 'ri-building-2-line'])
        </div>
    @endif
    <div class="2xl:col-span-1 lg:col-span-2">
        @include('partials.attex.stat-card', ['label' => 'Times', 'value' => $stats['teams'], 'icon' => 'ri-team-line'])
    </div>
    <div class="2xl:col-span-1 lg:col-span-2">
        @include('partials.attex.stat-card', ['label' => 'Atletas Ativos', 'value' => $stats['players'], 'icon' => 'ri-user-star-line'])
    </div>
    <div class="2xl:col-span-1 lg:col-span-2">
        @include('partials.attex.stat-card', ['label' => 'Próximos Treinos', 'value' => $stats['trainings'], 'icon' => 'ri-basketball-line'])
    </div>
    <div class="2xl:col-span-1 lg:col-span-2">
        @include('partials.attex.stat-card', ['label' => 'Próximos Jogos', 'value' => $stats['games'], 'icon' => 'ri-trophy-line'])
    </div>
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
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="bg-light/40 border-b border-gray-100 dark:bg-light/5 dark:border-b-gray-700">
                    <tr>
                        <th class="py-1.5 px-4">Treino</th>
                        <th class="py-1.5 px-4">Local</th>
                        <th class="py-1.5 px-4 text-end">Data</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($upcomingTrainings as $training)
                        <tr>
                            <td class="p-4 font-medium text-gray-800 dark:text-gray-200">
                                <a href="{{ route('trainings.show', $training) }}" class="hover:text-primary">{{ $training->title }}</a>
                            </td>
                            <td class="p-4">{{ $training->location ?? 'A definir' }}</td>
                            <td class="p-4 text-end">{{ $training->scheduled_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-4 text-center text-gray-400">Nenhum treino agendado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header flex justify-between items-center">
            <h4 class="card-title">Próximos Jogos</h4>
            <a href="{{ route('games.index') }}" class="btn btn-sm bg-light text-dark dark:bg-gray-700 dark:text-gray-200">Ver todos</a>
        </div>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="bg-light/40 border-b border-gray-100 dark:bg-light/5 dark:border-b-gray-700">
                    <tr>
                        <th class="py-1.5 px-4">Confronto</th>
                        <th class="py-1.5 px-4">Local</th>
                        <th class="py-1.5 px-4 text-end">Data</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($upcomingGames as $game)
                        <tr>
                            <td class="p-4 font-medium text-gray-800 dark:text-gray-200">
                                <a href="{{ route('games.show', $game) }}" class="hover:text-primary">vs {{ $game->opponent }}</a>
                            </td>
                            <td class="p-4">{{ $game->location ?? 'A definir' }}</td>
                            <td class="p-4 text-end">{{ $game->scheduled_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="p-4 text-center text-gray-400">Nenhum jogo agendado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection