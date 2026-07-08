<div class="grid md:grid-cols-2 gap-4">
    @include('partials.club-select', ['selectedClubId' => optional($sponsor)->club_id ?? null])

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Nome *</label>
        <input type="text" name="name" class="form-input" value="{{ old('name', optional($sponsor)->name ?? '') }}" required>
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Nível *</label>
        <select name="tier" class="form-select" required>
            <option value="">Selecione</option>
            @foreach ($tiers as $tier)
                <option value="{{ $tier->value }}" @selected(old('tier', optional($sponsor)->tier?->value ?? '') == $tier->value)>{{ $tier->label() }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Logo</label>
        <input type="file" name="logo" class="form-input" accept="image/*">
        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Exibido na seção de patrocinadores da landing.</p>
        @if (optional($sponsor)->logo)
            <div class="mt-2">
                <img src="{{ sponsor_logo_url($sponsor) }}" alt="{{ $sponsor->name }}" class="h-12 object-contain rounded border border-gray-200 dark:border-gray-700 p-1 bg-white dark:bg-gray-800">
            </div>
        @endif
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Site</label>
        <input type="url" name="website" class="form-input" placeholder="https://empresa.com.br" value="{{ old('website', optional($sponsor)->website ?? '') }}">
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Valor do Contrato (R$)</label>
        <input type="number" name="contract_amount" class="form-input" min="0" step="0.01" value="{{ old('contract_amount', optional($sponsor)->contract_amount ?? '') }}">
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Ordem de Exibição</label>
        <input type="number" name="sort_order" class="form-input" min="0" max="9999" value="{{ old('sort_order', optional($sponsor)->sort_order ?? '') }}" placeholder="Menor = primeiro">
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Início do Contrato</label>
        <input type="date" name="starts_at" class="form-input" value="{{ old('starts_at', optional($sponsor)->starts_at?->format('Y-m-d') ?? '') }}">
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Fim do Contrato</label>
        <input type="date" name="ends_at" class="form-input" value="{{ old('ends_at', optional($sponsor)->ends_at?->format('Y-m-d') ?? '') }}">
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Contato</label>
        <input type="text" name="contact_name" class="form-input" value="{{ old('contact_name', optional($sponsor)->contact_name ?? '') }}">
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">E-mail do Contato</label>
        <input type="email" name="contact_email" class="form-input" value="{{ old('contact_email', optional($sponsor)->contact_email ?? '') }}">
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Telefone do Contato</label>
        <input type="text" name="contact_phone" class="form-input" value="{{ old('contact_phone', optional($sponsor)->contact_phone ?? '') }}">
    </div>

    <div class="md:col-span-2">
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Observações</label>
        <textarea name="notes" class="form-input" rows="3">{{ old('notes', optional($sponsor)->notes ?? '') }}</textarea>
    </div>

    <div class="flex items-center gap-2">
        <input type="hidden" name="show_on_landing" value="0">
        <input type="checkbox" name="show_on_landing" value="1" id="show_on_landing" class="form-checkbox rounded text-primary" {{ old('show_on_landing', optional($sponsor)->show_on_landing ?? true) ? 'checked' : '' }}>
        <label for="show_on_landing" class="text-gray-700 dark:text-gray-300">Exibir na landing</label>
    </div>

    @isset($sponsor)
        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" id="is_active" class="form-checkbox rounded text-primary" {{ old('is_active', optional($sponsor)->is_active) ? 'checked' : '' }}>
            <label for="is_active" class="text-gray-700 dark:text-gray-300">Patrocinador ativo</label>
        </div>
    @endisset

    <div class="md:col-span-2 flex items-center gap-2">
        <input type="hidden" name="record_financial" value="0">
        <input type="checkbox" name="record_financial" value="1" id="record_financial" class="form-checkbox rounded text-primary" {{ old('record_financial') ? 'checked' : '' }}>
        <label for="record_financial" class="text-gray-700 dark:text-gray-300">Registrar valor como receita financeira (categoria patrocínio)</label>
    </div>
</div>