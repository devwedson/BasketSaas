@php
    $staff = $staff ?? null;
    $teams = $teams ?? collect();
    $roles = $roles ?? [];
@endphp

<div class="grid md:grid-cols-2 gap-4">
    @include('partials.club-select', ['selectedClubId' => optional($staff)->club_id ?? null])
    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Time</label>
        <select name="team_id" class="form-select"><option value="">Selecione</option>@foreach ($teams as $team)<option value="{{ $team->id }}" @selected(old('team_id', optional($staff)->team_id ?? null) == $team->id)>{{ $team->name }}</option>@endforeach</select>
    </div>
    <div><label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Nome *</label><input type="text" name="name" class="form-input" value="{{ old('name', optional($staff)->name ?? '') }}" required></div>
    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Função *</label>
        <select name="role" class="form-select" required><option value="">Selecione</option>@foreach ($roles as $role)<option value="{{ $role->value }}" @selected(old('role', optional($staff)->role?->value ?? '') == $role->value)>{{ $role->label() }}</option>@endforeach</select>
    </div>
    <div><label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">E-mail</label><input type="email" name="email" class="form-input" value="{{ old('email', optional($staff)->email ?? '') }}"></div>
    <div><label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Telefone</label><input type="text" name="phone" class="form-input" value="{{ old('phone', optional($staff)->phone ?? '') }}"></div>
    <div>
        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Foto (landing)</label>
        <input type="file" name="photo" class="form-input" accept="image/*">
        @if (optional($staff)->photo)
            <div class="mt-2">
                <img src="{{ staff_photo_url($staff) }}" alt="{{ $staff->name }}" class="h-20 w-20 object-cover rounded border border-gray-200 dark:border-gray-700">
            </div>
        @endif
    </div>
    @isset($staff)
        <div class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" class="form-checkbox rounded text-primary" {{ old('is_active', optional($staff)->is_active) ? 'checked' : '' }}><label>Ativo</label></div>
    @endisset
</div>