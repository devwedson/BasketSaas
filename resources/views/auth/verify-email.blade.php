@extends('layouts.attex.auth')

@section('title', 'Ativar Conta')

@section('content')
<div class="card overflow-hidden">
    <div class="p-9 bg-primary">
        <a href="{{ route('landing') }}" class="flex justify-center">
            <img src="{{ attex_asset(config('attex.brand.logo_light')) }}" alt="{{ config('app.name') }}" class="h-6 block dark:hidden">
            <img src="{{ attex_asset(config('attex.brand.logo_dark')) }}" alt="{{ config('app.name') }}" class="h-6 hidden dark:block">
        </a>
    </div>

    <div class="p-9 text-center">
        <div class="flex justify-center mb-4">
            <span class="flex items-center justify-center h-16 w-16 rounded-full bg-primary/10 text-primary">
                <i class="ri-mail-send-line text-3xl"></i>
            </span>
        </div>

        <h4 class="text-lg font-bold text-dark/70 dark:text-light/80 mb-2">Ative sua conta</h4>
        <p class="text-gray-500 dark:text-gray-400 text-sm mb-6">
            Enviamos um link de ativação para <strong class="text-gray-700 dark:text-gray-200">{{ auth()->user()->email }}</strong>.
            Abra seu e-mail e clique no botão para confirmar o cadastro.
        </p>

        @if (session('success'))
            <div class="mb-4 p-3 rounded-md bg-success/10 text-success text-sm">{{ session('success') }}</div>
        @endif

        @if (session('warning'))
            <div class="mb-4 p-3 rounded-md bg-warning/10 text-warning text-sm text-start">{{ session('warning') }}</div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-md bg-danger/10 text-danger text-sm">{{ $errors->first() }}</div>
        @endif

        @if (! $smtpConfigured)
            <div class="mb-4 p-3 rounded-md bg-warning/10 text-warning text-sm text-start">
                O servidor de e-mail ainda não está configurado. Peça ao administrador para configurar o SMTP no painel.
            </div>
        @endif

        @if ($smtpConfigured)
            <form method="POST" action="{{ route('verification.resend') }}" class="mb-4">
                @csrf
                <button type="submit" class="btn bg-primary text-white w-full">
                    <i class="ri-refresh-line me-1"></i> Reenviar e-mail de ativação
                </button>
            </form>
        @endif

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn bg-light text-dark dark:bg-gray-700 dark:text-gray-200 w-full">Sair</button>
        </form>
    </div>
</div>

@include('partials.attex.auth-footer-links', [
    'secondaryUrl' => route('landing'),
    'secondaryLabel' => 'Voltar ao site',
])
@endsection