<div class="grid md:grid-cols-2 gap-4">
    @include('partials.club-select', ['selectedClubId' => optional($player)->club_id])

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Time</label>
        <select name="team_id" class="form-select">
            <option value="">Selecione</option>
            @foreach ($teams as $team)
                <option value="{{ $team->id }}" @selected(old('team_id', optional($player)->team_id) == $team->id)>{{ $team->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Nome *</label>
        <input type="text" name="name" class="form-input" value="{{ old('name', optional($player)->name) }}" required>
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Número</label>
        <input type="number" name="number" class="form-input" min="0" max="99" value="{{ old('number', optional($player)->number ?? '') }}">
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Posição</label>
        <select name="position" class="form-select">
            <option value="">Selecione</option>
            @foreach ($positions as $position)
                <option value="{{ $position->value }}" @selected(old('position', optional($player)->position?->value ?? '') == $position->value)>{{ $position->label() }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Data de Nascimento</label>
        <input type="date" name="birth_date" class="form-input" value="{{ old('birth_date', isset($player) && optional($player)->birth_date ? optional($player)->birth_date->format('Y-m-d') : '') }}">
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">E-mail</label>
        <input type="email" name="email" class="form-input" value="{{ old('email', optional($player)->email ?? '') }}">
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Telefone</label>
        <input type="text" name="phone" class="form-input" value="{{ old('phone', optional($player)->phone ?? '') }}">
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Altura (cm)</label>
        <input type="number" step="0.1" name="height_cm" class="form-input" value="{{ old('height_cm', optional($player)->height_cm ?? '') }}">
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Peso (kg)</label>
        <input type="number" step="0.1" name="weight_kg" class="form-input" value="{{ old('weight_kg', optional($player)->weight_kg ?? '') }}">
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Responsável</label>
        <input type="text" name="guardian_name" class="form-input" value="{{ old('guardian_name', optional($player)->guardian_name ?? '') }}">
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Tel. Responsável</label>
        <input type="text" name="guardian_phone" class="form-input" value="{{ old('guardian_phone', optional($player)->guardian_phone ?? '') }}">
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">E-mail Responsável</label>
        <input type="email" name="guardian_email" class="form-input" value="{{ old('guardian_email', optional($player)->guardian_email ?? '') }}">
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Foto (landing)</label>
        <input type="file" name="photo" class="form-input" accept="image/*">
        @if (optional($player)->photo)
            <div class="mt-2">
                <img src="{{ player_photo_url($player) }}" alt="{{ $player->name }}" class="h-20 w-20 object-cover rounded border border-gray-200 dark:border-gray-700">
            </div>
        @endif
    </div>

    @isset($player)
        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" class="form-checkbox rounded text-primary" {{ old('is_active', optional($player)->is_active) ? 'checked' : '' }}>
            <label>Atleta ativo</label>
        </div>
    @endisset
</div>