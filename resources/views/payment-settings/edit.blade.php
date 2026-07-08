@extends('layouts.attex.app')

@section('title', 'Pagamentos')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Pagamentos / Mercado Pago',
    'subtitle' => 'Configure a taxa de inscrição da comissão técnica',
    'breadcrumbs' => [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'Pagamentos'],
    ],
])

@include('partials.attex.form-card-open', [
    'formTitle' => 'Inscrição da Comissão Técnica',
    'formSubtitle' => 'Ao cadastrar um técnico com acesso ao painel, o sistema gera automaticamente a cobrança',
    'formAction' => route('payment.settings.update'),
    'formMethod' => 'PUT',
])
    <div class="grid md:grid-cols-2 gap-4">
        <div class="md:col-span-2 flex items-center gap-2">
            <input type="hidden" name="inscription_enabled" value="0">
            <input type="checkbox" name="inscription_enabled" value="1" id="inscription_enabled" class="form-checkbox rounded text-primary" {{ old('inscription_enabled', $settings['inscription_enabled']) ? 'checked' : '' }}>
            <label for="inscription_enabled" class="font-semibold text-gray-700 dark:text-gray-300">Cobrar inscrição ao criar acesso da comissão técnica</label>
        </div>

        <div>
            <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Valor da inscrição (R$) *</label>
            <input type="number" name="inscription_amount" class="form-input" min="1" step="0.01" value="{{ old('inscription_amount', $settings['inscription_amount']) }}">
        </div>

        <div>
            <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Descrição no checkout</label>
            <input type="text" name="inscription_description" class="form-input" value="{{ old('inscription_description', $settings['inscription_description']) }}">
        </div>

        <div class="md:col-span-2">
            <hr class="border-gray-200 dark:border-gray-700 my-2">
            <h5 class="font-semibold text-gray-700 dark:text-gray-300 mb-3">Mercado Pago</h5>
        </div>

        <div>
            <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Public Key</label>
            <input type="text" name="public_key" class="form-input" value="{{ old('public_key', $settings['public_key']) }}" placeholder="APP_USR-...">
        </div>

        <div>
            <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Access Token</label>
            <input type="password" name="access_token" class="form-input" placeholder="{{ $settings['access_token'] ? '•••••••• (deixe em branco para manter)' : 'APP_USR-...' }}" autocomplete="new-password">
        </div>

        <div class="md:col-span-2 flex items-center gap-2">
            <input type="hidden" name="sandbox" value="0">
            <input type="checkbox" name="sandbox" value="1" id="sandbox" class="form-checkbox rounded text-primary" {{ old('sandbox', $settings['sandbox']) ? 'checked' : '' }}>
            <label for="sandbox" class="text-gray-700 dark:text-gray-300">Modo sandbox (testes)</label>
        </div>

        <div class="md:col-span-2">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Webhook: <code class="text-xs">{{ route('webhooks.mercadopago') }}</code><br>
                Configure esta URL em <a href="https://www.mercadopago.com.br/developers/panel/app" target="_blank" rel="noopener" class="text-primary">Suas integrações → Webhooks</a> com o evento <strong>payment</strong>.
            </p>
        </div>
    </div>
@include('partials.attex.form-card-close', ['cancelUrl' => route('dashboard'), 'submitLabel' => 'Salvar Pagamentos'])
@endsection