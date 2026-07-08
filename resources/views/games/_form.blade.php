<div class="grid md:grid-cols-2 gap-4">
    @include('partials.club-select', ['selectedClubId' => optional($game)->club_id])

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Time</label>
        <select name="team_id" class="form-select">
            <option value="">Selecione</option>
            @foreach ($teams as $team)
                <option value="{{ $team->id }}" @selected(old('team_id', optional($game)->team_id) == $team->id)>{{ $team->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Adversário *</label>
        <input type="text" name="opponent" class="form-input" value="{{ old('opponent', optional($game)->opponent) }}" required>
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Logo do Adversário</label>
        <input type="file" name="opponent_logo" class="form-input" accept="image/*">
        @if (optional($game)->opponent_logo)
            <div class="mt-2">
                <img src="{{ game_opponent_logo_url($game) }}" alt="{{ $game->opponent }}" class="h-12 w-12 object-contain rounded border border-gray-200 dark:border-gray-700">
            </div>
        @endif
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Data/Hora *</label>
        <input type="datetime-local" name="scheduled_at" class="form-input" value="{{ old('scheduled_at', optional($game)->scheduled_at?->format('Y-m-d\TH:i')) }}" required>
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Local</label>
        <input type="text" name="location" class="form-input" value="{{ old('location', optional($game)->location) }}">
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Placar (Casa)</label>
        <input type="number" name="home_score" class="form-input" min="0" value="{{ old('home_score', optional($game)->home_score) }}">
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Placar (Visitante)</label>
        <input type="number" name="away_score" class="form-input" min="0" value="{{ old('away_score', optional($game)->away_score) }}">
    </div>

    <div class="md:col-span-2">
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Imagem de Capa (landing)</label>
        <input type="file" name="cover_image" class="form-input" accept="image/*">
        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Exibida nos cards de jogos e notícias da landing.</p>
        @if (optional($game)->cover_image)
            <div class="mt-2">
                <img src="{{ game_cover_image_url($game) }}" alt="Capa do jogo" class="h-24 w-full max-w-xs object-cover rounded border border-gray-200 dark:border-gray-700">
            </div>
        @endif
    </div>

    <div class="flex items-center gap-2">
        <input type="checkbox" name="is_home" value="1" class="form-checkbox rounded text-primary" {{ old('is_home', optional($game)->is_home ?? true) ? 'checked' : '' }}>
        <label>Jogo em casa</label>
    </div>

    <div class="md:col-span-2">
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Observações</label>
        <textarea name="notes" class="form-input" rows="3">{{ old('notes', optional($game)->notes) }}</textarea>
    </div>
</div>