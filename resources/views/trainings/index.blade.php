@extends('layouts.attex.app')

@section('title', 'Treinos')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Treinos',
    'subtitle' => 'Agenda de treinos e presença dos atletas',
    'breadcrumbs' => [['label' => 'Dashboard', 'url' => route('dashboard')], ['label' => 'Treinos']],
    'actionUrl' => route('trainings.create'),
    'actionLabel' => 'Novo Treino',
    'actionIcon' => 'ri-add-line',
])

<div class="card">
    <div class="card-header flex justify-between items-center">
        <h4 class="card-title">Lista de Treinos</h4>
        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $trainings->total() }} registro(s)</span>
    </div>
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr>
                        <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Título</th>
                        <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Data/Hora</th>
                        <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Local</th>
                        <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Time</th>
                        <th scope="col" class="px-4 py-4 text-end text-sm font-medium text-gray-500 dark:text-gray-400">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($trainings as $training)
                        <tr>
                            <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">{{ $training->title }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $training->scheduled_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $training->location ?? '-' }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $training->team?->name ?? '-' }}</td>
                            <td class="px-4 py-4 whitespace-nowrap text-end">
                                @include('partials.attex.row-actions', [
                                    'showUrl' => route('trainings.show', $training),
                                    'editUrl' => route('trainings.edit', $training),
                                    'deleteUrl' => route('trainings.destroy', $training),
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

@include('partials.attex.pagination', ['paginator' => $trainings])
@endsection