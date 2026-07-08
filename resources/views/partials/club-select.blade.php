@php
    $clubs = $clubs ?? collect();
@endphp

@if (auth()->user()->isSuperAdmin())
    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Clube *</label>
        <select name="club_id" class="form-select" required>
            <option value="">Selecione</option>
            @foreach ($clubs as $club)
                <option value="{{ $club->id }}" @selected(old('club_id', $selectedClubId ?? null) == $club->id)>
                    {{ $club->name }}
                </option>
            @endforeach
        </select>
    </div>
@endif