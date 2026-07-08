@extends('layouts.attex.app')

@section('title', 'Pagamento da Inscrição')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Pagamento da Inscrição',
    'subtitle' => 'Conclua o pagamento para liberar seu acesso ao painel',
    'breadcrumbs' => [
        ['label' => 'Inscrição'],
    ],
])

<div class="max-w-2xl mx-auto">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Cobrança pendente</h4>
        </div>
        <div class="p-6 space-y-4">
            <dl class="grid gap-3">
                <div class="flex justify-between gap-4">
                    <dt class="text-gray-500 dark:text-gray-400">Profissional</dt>
                    <dd class="font-medium text-gray-800 dark:text-gray-200">{{ $payment->staff->name }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-gray-500 dark:text-gray-400">Clube</dt>
                    <dd class="font-medium text-gray-800 dark:text-gray-200">{{ $payment->club->name }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-gray-500 dark:text-gray-400">Valor</dt>
                    <dd class="font-semibold text-primary text-lg">R$ {{ number_format($payment->amount, 2, ',', '.') }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-gray-500 dark:text-gray-400">Status</dt>
                    <dd>{{ $payment->status->label() }}</dd>
                </div>
            </dl>

            @if ($mercadoPagoReady && $checkoutUrl)
                <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                        Você será redirecionado ao Mercado Pago para pagar com PIX, cartão ou boleto.
                        Após a confirmação, seu acesso ao painel será liberado automaticamente.
                    </p>
                    <a href="{{ $checkoutUrl }}" class="btn bg-primary text-white w-full sm:w-auto">
                        <i class="ri-bank-card-line me-1"></i> Pagar inscrição no Mercado Pago
                    </a>
                </div>
            @else
                <div class="p-4 rounded bg-warning/10 text-warning">
                    O Mercado Pago ainda não está configurado. Entre em contato com o administrador do clube.
                </div>
            @endif

            <form method="POST" action="{{ route('logout') }}" class="pt-2">
                @csrf
                <button type="submit" class="text-sm text-gray-500 hover:text-primary">Sair da conta</button>
            </form>
        </div>
    </div>
</div>
@endsection