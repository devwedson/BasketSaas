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
            <span class="text-sm text-slate-500 dark:text-slate-400">{{ count($dayEvents) }} evento(s)</span>
        </div>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="bg-light/40 border-b border-gray-100 dark:bg-light/5 dark:border-b-gray-700">
                    <tr>
                        <th class="py-1.5 px-4 w-28">Horário</th>
                        <th class="py-1.5 px-4 w-28">Tipo</th>
                        <th class="py-1.5 px-4">Evento</th>
                        <th class="py-1.5 px-4">Time</th>
                        <th class="py-1.5 px-4">Local</th>
                        <th class="py-1.5 px-4 text-end w-20">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dayEvents as $event)
                        <tr>
                            <td class="p-4 font-medium text-gray-800 dark:text-gray-200">{{ $event['datetime']->format('H:i') }}</td>
                            <td class="p-4">
                                <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-md text-xs font-medium {{ $event['type'] === 'training' ? 'bg-primary/10 text-primary' : 'bg-warning/10 text-warning' }}">
                                    <i class="{{ $event['type'] === 'training' ? 'ri-basketball-line' : 'ri-trophy-line' }}"></i>
                                    {{ $event['type'] === 'training' ? 'Treino' : 'Jogo' }}
                                </span>
                            </td>
                            <td class="p-4 text-gray-800 dark:text-gray-200">{{ $event['title'] }}</td>
                            <td class="p-4">{{ $event['team'] ?? 'Geral' }}</td>
                            <td class="p-4">{{ $event['location'] ?? 'A definir' }}</td>
                            <td class="p-4 text-end">
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
@empty
    <div class="card">
        <div class="p-6 text-center text-gray-500 dark:text-gray-400">
            <i class="ri-calendar-line text-4xl text-gray-300 dark:text-gray-600 mb-3 block"></i>
            Nenhum evento no calendário.
        </div>
    </div>
@endforelse
@endsection