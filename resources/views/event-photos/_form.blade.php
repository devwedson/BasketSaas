@php
    $eventPhoto = $eventPhoto ?? null;
@endphp

<div class="grid md:grid-cols-2 gap-4">
    <div class="md:col-span-2">
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Clube *</label>
        <select name="club_id" class="form-select" required>
            <option value="">Selecione</option>
            @foreach ($clubs as $club)
                <option value="{{ $club->id }}" @selected(old('club_id', optional($eventPhoto)->club_id ?? ($defaultClubId ?? null)) == $club->id)>{{ $club->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="md:col-span-2">
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Título do evento *</label>
        <input type="text" name="title" class="form-input" value="{{ old('title', optional($eventPhoto)->title ?? '') }}" required placeholder="Ex.: Festival de Basquete 2026">
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Data do evento</label>
        <input type="date" name="event_date" class="form-input" value="{{ old('event_date', optional($eventPhoto)->event_date?->format('Y-m-d') ?? '') }}">
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Ordem de exibição</label>
        <input type="number" name="sort_order" class="form-input" min="0" max="9999" value="{{ old('sort_order', optional($eventPhoto)->sort_order ?? 0) }}" placeholder="Menor = primeiro">
    </div>

    <div class="md:col-span-2">
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Descrição</label>
        <textarea name="description" class="form-input" rows="3" placeholder="Breve descrição do evento (opcional)">{{ old('description', optional($eventPhoto)->description ?? '') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Foto {{ isset($eventPhoto) ? '' : '*' }}</label>
        <input type="file" name="image" class="form-input" accept="image/*" {{ isset($eventPhoto) ? '' : 'required' }}>
        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Exibida na galeria de eventos da landing. Máx. 5 MB.</p>
        @if (optional($eventPhoto)->image)
            <div class="mt-2">
                <img src="{{ event_photo_url($eventPhoto) }}" alt="{{ $eventPhoto->title }}" class="h-32 w-auto object-cover rounded border border-gray-200 dark:border-gray-700">
            </div>
        @endif
    </div>

    <div class="md:col-span-2 flex items-center gap-2">
        <input type="checkbox" name="is_active" value="1" id="is_active" class="form-checkbox rounded text-primary" {{ old('is_active', optional($eventPhoto)->is_active ?? true) ? 'checked' : '' }}>
        <label for="is_active" class="text-gray-700 dark:text-gray-300">Exibir na landing</label>
    </div>
</div>