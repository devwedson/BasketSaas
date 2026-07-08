@extends('layouts.attex.auth')

@section('content')
<div class="card overflow-hidden">
    <div class="p-9 bg-primary">
        <a href="{{ route('landing') }}" class="flex justify-center">
            <img src="{{ attex_asset(config('attex.brand.logo_light')) }}" alt="{{ config('app.name') }}" class="h-6 block dark:hidden">
            <img src="{{ attex_asset(config('attex.brand.logo_dark')) }}" alt="{{ config('app.name') }}" class="h-6 hidden dark:block">
        </a>
    </div>

    <div class="p-9">
        <div class="text-center mx-auto w-3/4">
            <h4 class="text-dark/70 text-center text-lg font-bold dark:text-light/80 mb-2">Criar Conta</h4>
            <p class="text-gray-400 dark:text-gray-500 mb-9">Cadastre-se e ative seu e-mail para acessar o painel.</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-md bg-danger/10 text-danger text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-6 space-y-2">
                <label for="name" class="font-semibold text-gray-500 dark:text-gray-400">Nome</label>
                <input class="form-input" type="text" id="name" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="Seu nome">
            </div>

            <div class="mb-6 space-y-2">
                <label for="email" class="font-semibold text-gray-500 dark:text-gray-400">E-mail</label>
                <input class="form-input" type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="seu@email.com">
            </div>

            <div class="mb-6 space-y-2">
                <label for="password" class="font-semibold text-gray-500 dark:text-gray-400">Senha</label>
                <input type="password" id="password" name="password" class="form-input" required autocomplete="new-password" placeholder="Mínimo 8 caracteres">
            </div>

            <div class="mb-6 space-y-2">
                <label for="password_confirmation" class="font-semibold text-gray-500 dark:text-gray-400">Confirmar Senha</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" required autocomplete="new-password" placeholder="Repita a senha">
            </div>

            <div class="text-center mb-6">
                <button class="btn bg-primary text-white w-full" type="submit">Criar Conta</button>
            </div>
        </form>
    </div>
</div>

<div class="text-center my-4 space-y-2">
    <p class="text-sm text-gray-500 dark:text-gray-400">Já tem conta? <a href="{{ route('login') }}" class="underline underline-offset-4">Entrar</a></p>
    <a href="{{ route('landing') }}" class="text-muted text-sm underline underline-offset-4 block">Voltar ao site</a>
    <button id="light-dark-mode" type="button" class="mt-3 text-sm text-gray-500 dark:text-gray-400 hover:text-primary inline-flex items-center gap-1.5 mx-auto">
        <i class="ri-moon-line dark:hidden"></i>
        <i class="ri-sun-line hidden dark:inline"></i>
        Alternar tema
    </button>
</div>
@endsection