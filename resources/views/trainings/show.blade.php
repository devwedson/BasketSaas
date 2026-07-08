@extends('layouts.attex.app')

@section('title', $training->title)

@section('content')
@include('partials.attex.show-header', [
    'title' => $training->title,
    'subtitle' => $training->scheduled_at->format('d/m/Y H:i').' · '.($training->location ?? 'Local a definir'),
    'editUrl' => route('trainings.edit', $training),
    'backUrl' => route('trainings.index'),
])

<div class="card mb-6">
    <div class="card-header">
        <h4 class="card-title">Detalhes do Treino</h4>
    </div>
    <div class="p-6">
        <dl class="grid md:grid-cols-2 gap-6">
            @include('partials.attex.detail-item', ['label' => 'Time', 'value' => $training->team?->name])
            @include('partials.attex.detail-item', ['label' => 'Data/Hora', 'value' => $training->scheduled_at->format('d/m/Y H:i')])
            @include('partials.attex.detail-item', ['label' => 'Local', 'value' => $training->location])
            @include('partials.attex.detail-item', ['label' => 'Exercícios', 'value' => $training->exercises])
            <div class="md:col-span-2">
                @include('partials.attex.detail-item', ['label' => 'Observações', 'value' => $training->notes])
            </div>
        </dl>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Presença</h4>
    </div>
    <div class="p-6">
        <form method="POST" action="{{ route('trainings.attendance', $training) }}">
            @csrf
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr>
                            <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400 w-24">Presente</th>
                            <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Jogador</th>
                            <th scope="col" class="px-4 py-4 text-start text-sm font-medium text-gray-500 dark:text-gray-400">Observação</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($players as $player)
                            @php $att = $training->attendance->firstWhere('player_id', $player->id); @endphp
                            <tr>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <input type="checkbox" name="attendance[{{ $player->id }}]" value="1" class="form-checkbox rounded text-primary" {{ $att?->present ? 'checked' : '' }}>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">{{ $player->name }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <input type="text" name="notes[{{ $player->id }}]" class="form-input" value="{{ $att?->notes }}">
                                </td>
                            </tr>
                        @empty
                            @include('partials.attex.empty-row', ['colspan' => 3, 'message' => 'Nenhum jogador disponível.'])
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($players->isNotEmpty())
                <div class="flex gap-2 pt-6 mt-6 border-t border-gray-100 dark:border-gray-700">
                    <button type="submit" class="btn bg-primary text-white"><i class="ri-save-line me-1"></i> Salvar Presença</button>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection