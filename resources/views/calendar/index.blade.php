@extends('layouts.attex.app')

@section('title', 'Calendário')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Calendário',
    'subtitle' => 'Treinos e jogos agendados',
    'breadcrumbs' => [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Calendário'],
    ],
])

@forelse ($events as $date => $dayEvents)
    <div class="card mb-6">
        <div class="card-header flex justify-between items-center">
            <h4 class="card-title">{{ \Carbon\Carbon::parse($date)->translatedFormat('l, d/m/Y') }}</h4>
            <span class="text-sm text-gray-500 dark:text-gray-400">{{ count($dayEvents) }} evento(s)</span>
        </div>
        <div class="p-0">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr>
                            <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400 w-28">Horário</th>
                            <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400 w-28">Tipo</th>
                            <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Evento</th>
                            <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Time</th>
                            <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Local</th>
                            <th scope="col" class="px-4 py-4 text-end text-sm font-medium text-gray-500 dark:text-gray-400 w-20">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($dayEvents as $event)
                            <tr>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">{{ $event['datetime']->format('H:i') }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-md text-xs font-medium {{ $event['type'] === 'training' ? 'bg-primary/10 text-primary' : 'bg-warning/10 text-warning' }}">
                                        <i class="{{ $event['type'] === 'training' ? 'ri-basketball-line' : 'ri-trophy-line' }}"></i>
                                        {{ $event['type'] === 'training' ? 'Treino' : 'Jogo' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">{{ $event['title'] }}</td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $event['team'] ?? 'Geral' }}</td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $event['location'] ?? 'A definir' }}</td>
                                <td class="px-4 py-4 whitespace-nowrap text-end">
                                    <a href="{{ $event['url'] }}" class="btn btn-sm bg-light text-dark dark:bg-gray-700 dark:text-gray-200" title="Ver">
                                        <i class="ri-eye-line"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@empty
    <div class="card">
        <div class="p-6 text-center text-gray-500 dark:text-gray-400">
            <i class="ri-calendar-line text-4xl text-gray-300 dark:text-gray-600 mb-3 block"></i>
            Nenhum evento no calendário.
        </div>
    </div>
@endforelse
@endsection