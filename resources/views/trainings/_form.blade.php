@php
    $training = $training ?? null;
    $teams = $teams ?? collect();
@endphp

<div class="grid md:grid-cols-2 gap-4">
    @include('partials.club-select', ['selectedClubId' => optional($training)->club_id])
    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Time</label>
        <select name="team_id" class="form-select"><option value="">Selecione</option>@foreach ($teams as $team)<option value="{{ $team->id }}" @selected(old('team_id', optional($training)->team_id) == $team->id)>{{ $team->name }}</option>@endforeach</select>
    </div>
    <div><label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Título *</label><input type="text" name="title" class="form-input" value="{{ old('title', optional($training)->title) }}" required></div>
    <div><label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Data/Hora *</label><input type="datetime-local" name="scheduled_at" class="form-input" value="{{ old('scheduled_at', optional($training)->scheduled_at?->format('Y-m-d\TH:i')) }}" required></div>
    <div><label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Local</label><input type="text" name="location" class="form-input" value="{{ old('location', optional($training)->location) }}"></div>
    <div class="md:col-span-2"><label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Exercícios</label><textarea name="exercises" class="form-input" rows="3">{{ old('exercises', optional($training)->exercises) }}</textarea></div>
    <div class="md:col-span-2"><label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Observações</label><textarea name="notes" class="form-input" rows="3">{{ old('notes', optional($training)->notes) }}</textarea></div>
</div>