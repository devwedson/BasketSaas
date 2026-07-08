@extends('layouts.attex.app')

@section('title', 'Landing do Clube')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Landing do Clube',
    'subtitle' => 'Imagens e textos exibidos no site público ('.$club->name.')',
    'breadcrumbs' => [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Landing do Clube'],
    ],
    'actionsView' => 'club-settings.partials.landing-link',
])

@include('partials.attex.form-card-open', [
    'formTitle' => 'Configurações da Landing',
    'formSubtitle' => 'Logo, capas e informações de contato',
    'formAction' => route('club.settings.update'),
    'formMethod' => 'PUT',
    'enctype' => 'multipart/form-data',
])
    <div class="grid md:grid-cols-2 gap-4">
        <div class="md:col-span-2">
            <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Descrição (landing)</label>
            <textarea name="description" class="form-input" rows="4">{{ old('description', $club->description) }}</textarea>
        </div>

        <div>
            <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">E-mail</label>
            <input type="email" name="email" class="form-input" value="{{ old('email', $club->email) }}">
        </div>

        <div>
            <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Telefone</label>
            <input type="text" name="phone" class="form-input" value="{{ old('phone', $club->phone) }}">
        </div>

        <div class="md:col-span-2">
            <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Endereço</label>
            <input type="text" name="address" class="form-input" value="{{ old('address', $club->address) }}">
        </div>

        <div>
            <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Cidade</label>
            <input type="text" name="city" class="form-input" value="{{ old('city', $club->city) }}">
        </div>

        <div>
            <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Estado</label>
            <input type="text" name="state" class="form-input" maxlength="2" value="{{ old('state', $club->state) }}">
        </div>

        <div>
            <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Logo (header/rodapé)</label>
            <input type="file" name="logo" class="form-input" accept="image/*">
            @if ($club->logo)
                <div class="mt-2">
                    <img src="{{ club_logo_url($club) }}" alt="{{ $club->name }}" class="h-12 object-contain rounded border border-gray-200 dark:border-gray-700 p-1">
                </div>
            @endif
        </div>

        <div>
            <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Imagem de capa (sobre)</label>
            <input type="file" name="cover_image" class="form-input" accept="image/*">
            @if ($club->cover_image)
                <div class="mt-2">
                    <img src="{{ club_cover_image_url($club) }}" alt="Capa" class="h-24 w-full max-w-xs object-cover rounded border border-gray-200 dark:border-gray-700">
                </div>
            @endif
        </div>

        <div class="md:col-span-2">
            <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Imagem de contato</label>
            <input type="file" name="contact_image" class="form-input" accept="image/*">
            @if ($club->contact_image)
                <div class="mt-2">
                    <img src="{{ club_contact_image_url($club) }}" alt="Contato" class="h-24 w-full max-w-xs object-cover rounded border border-gray-200 dark:border-gray-700">
                </div>
            @endif
        </div>
    </div>
@include('partials.attex.form-card-close', ['cancelUrl' => route('dashboard'), 'cancelLabel' => 'Voltar', 'submitLabel' => 'Salvar Configurações'])
@endsection