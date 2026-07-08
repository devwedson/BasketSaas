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
                    <button type="button" class="px-3 py-1 border rounded-e-md -ms-px dark:border-white/10" data-toggle-password aria-label="Mostrar senha">
                        <i class="ri-eye-line text-lg"></i>
                    </button>
                </div>
            </div>

            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" class="form-checkbox rounded text-primary" id="remember" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                    <span class="ms-2" for="remember">Lembrar-me</span>
                </label>
            </div>

            <div class="text-center mb-6">
                <button class="btn bg-primary text-white w-full" type="submit">Entrar</button>
            </div>
        </form>
    </div>
</div>

<div class="text-center my-4 space-y-2">
    <p class="text-sm text-gray-500 dark:text-gray-400">Não tem conta? <a href="{{ route('register') }}" class="underline underline-offset-4">Criar conta</a></p>
    <a href="{{ route('landing') }}" class="text-muted text-sm underline underline-offset-4 block">Voltar ao site</a>
    <button id="light-dark-mode" type="button" class="mt-3 text-sm text-gray-500 dark:text-gray-400 hover:text-primary inline-flex items-center gap-1.5 mx-auto">
        <i class="ri-moon-line dark:hidden"></i>
        <i class="ri-sun-line hidden dark:inline"></i>
        Alternar tema
    </button>
</div>
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