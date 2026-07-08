@php
    $club = $club ?? null;
@endphp

<div class="grid md:grid-cols-2 gap-4">
    <div class="md:col-span-2">
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Nome *</label>
        <input type="text" name="name" class="form-input" value="{{ old('name', $club?->name ?? '') }}" required>
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">E-mail</label>
        <input type="email" name="email" class="form-input" value="{{ old('email', $club?->email ?? '') }}">
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Telefone</label>
        <input type="text" name="phone" class="form-input" value="{{ old('phone', $club?->phone ?? '') }}">
    </div>

    <div class="md:col-span-2">
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Endereço</label>
        <input type="text" name="address" class="form-input" value="{{ old('address', $club?->address ?? '') }}">
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Cidade</label>
        <input type="text" name="city" class="form-input" value="{{ old('city', $club?->city ?? '') }}">
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Estado</label>
        <input type="text" name="state" class="form-input" maxlength="2" value="{{ old('state', $club?->state ?? '') }}">
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">CEP</label>
        <input type="text" name="zip_code" class="form-input" value="{{ old('zip_code', $club?->zip_code ?? '') }}">
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">País</label>
        <input type="text" name="country" class="form-input" value="{{ old('country', $club?->country ?? 'Brasil') }}">
    </div>

    <div class="md:col-span-2">
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Descrição (landing)</label>
        <textarea name="description" class="form-input" rows="4">{{ old('description', $club?->description ?? '') }}</textarea>
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Logo (header/rodapé landing)</label>
        <input type="file" name="logo" class="form-input" accept="image/*">
        @if ($club?->logo)
            <div class="mt-2">
                <img src="{{ club_logo_url($club) }}" alt="{{ $club->name }}" class="h-12 object-contain rounded border border-gray-200 dark:border-gray-700 p-1">
            </div>
        @endif
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Imagem de Capa (sobre)</label>
        <input type="file" name="cover_image" class="form-input" accept="image/*">
        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Exibida na seção sobre da landing.</p>
        @if ($club?->cover_image)
            <div class="mt-2">
                <img src="{{ club_cover_image_url($club) }}" alt="Capa do clube" class="h-24 w-full max-w-xs object-cover rounded border border-gray-200 dark:border-gray-700">
            </div>
        @endif
    </div>

    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Imagem de Contato</label>
        <input type="file" name="contact_image" class="form-input" accept="image/*">
        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Exibida na página de contato da landing.</p>
        @if ($club?->contact_image)
            <div class="mt-2">
                <img src="{{ club_contact_image_url($club) }}" alt="Contato" class="h-24 w-full max-w-xs object-cover rounded border border-gray-200 dark:border-gray-700">
            </div>
        @endif
    </div>

    @if ($club)
        <div class="flex items-center gap-2 mt-6">
            <input type="checkbox" name="is_active" value="1" class="form-checkbox rounded text-primary" {{ old('is_active', $club->is_active) ? 'checked' : '' }}>
            <label>Clube ativo</label>
        </div>
    @endif
</div>