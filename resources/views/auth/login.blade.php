@extends('layouts.attex.auth')

@section('title', config('attex.auth.title'))

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
            <h4 class="text-dark/70 text-center text-lg font-bold dark:text-light/80 mb-2">{{ config('attex.auth.title') }}</h4>
            <p class="text-gray-400 dark:text-gray-500 mb-9">{{ config('attex.auth.subtitle') }}</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-md bg-danger/10 text-danger text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-6 space-y-2">
                <label for="email" class="font-semibold text-gray-500 dark:text-gray-400">E-mail</label>
                <input class="form-input" type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="seu@email.com">
            </div>

            <div class="mb-6 space-y-2">
                <label for="password" class="font-semibold text-gray-500 dark:text-gray-400">Senha</label>
                <div class="flex items-center">
                    <input type="password" id="password" name="password" class="form-input rounded-e-none" required autocomplete="current-password" placeholder="Sua senha">
                    <button type="button" class="px-3 py-1 border rounded-e-md -ms-px dark:border-white/10 bg-transparent" data-toggle-password aria-label="Mostrar senha">
                        <i class="ri-eye-line text-lg"></i>
                    </button>
                </div>
            </div>

            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" class="form-checkbox rounded text-primary" id="remember" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                    <label class="ms-2" for="remember">Lembrar-me</label>
                </div>
            </div>

            <div class="text-center mb-6">
                <button class="btn bg-primary text-white" type="submit">Entrar</button>
            </div>
        </form>
    </div>
</div>

@include('partials.attex.auth-footer-links', [
    'registerText' => 'Não tem conta?',
    'registerUrl' => route('register'),
    'registerLinkLabel' => 'Criar conta',
    'secondaryUrl' => route('landing'),
    'secondaryLabel' => 'Voltar ao site',
])
@endsection

@push('scripts')
<script>
    document.querySelectorAll('[data-toggle-password]').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = document.getElementById('password');
            const icon = btn.querySelector('i');
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            icon.classList.toggle('ri-eye-line', !isPassword);
            icon.classList.toggle('ri-eye-off-line', isPassword);
        });
    });
</script>
@endpush