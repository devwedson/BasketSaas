<div class="grid md:grid-cols-2 gap-4">
    @include('partials.club-select', ['selectedClubId' => optional($team)->club_id ?? null])

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Temporada</label>
        <select name="season_id" class="form-select">
            <option value="">Selecione</option>
            @foreach ($seasons as $season)
                <option value="{{ $season->id }}" @selected(old('season_id', optional($team)->season_id ?? null) == $season->id)>
                    {{ $season->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Nome *</label>
        <input type="text" name="name" class="form-input" value="{{ old('name', optional($team)->name ?? '') }}" required>
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Logo do Time</label>
        <input type="file" name="logo" class="form-input" accept="image/*">
        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Usado nos confrontos de jogos na landing.</p>
        @if (optional($team)->logo)
            <div class="mt-2">
                <img src="{{ team_logo_url($team) }}" alt="{{ $team->name }}" class="h-16 w-16 object-contain rounded border border-gray-200 dark:border-gray-700">
            </div>
        @endif
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Imagem de Capa</label>
        <input type="file" name="cover_image" class="form-input" accept="image/*">
        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Exibida nos cards de programas na landing.</p>
        @if (optional($team)->cover_image)
            <div class="mt-2">
                <img src="{{ team_cover_image_url($team) }}" alt="{{ $team->name }}" class="h-24 w-full max-w-xs object-cover rounded border border-gray-200 dark:border-gray-700">
            </div>
        @endif
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Categoria</label>
        <input type="text" name="category" class="form-input" placeholder="Ex: Sub-16, Adulto" value="{{ old('category', optional($team)->category ?? '') }}">
    </div>

    <div class="md:col-span-2">
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Descrição</label>
        <textarea name="description" class="form-input" rows="3" placeholder="Descrição exibida na landing (programas)">{{ old('description', optional($team)->description ?? '') }}</textarea>
    </div>

    <div class="md:col-span-2">
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Uniforme</label>
        <textarea name="uniform_description" class="form-input" rows="3">{{ old('uniform_description', optional($team)->uniform_description ?? '') }}</textarea>
    </div>

    @isset($team)
        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" class="form-checkbox rounded text-primary" {{ old('is_active', optional($team)->is_active) ? 'checked' : '' }}>
            <label>Time ativo</label>
        </div>
    @endisset
</div>