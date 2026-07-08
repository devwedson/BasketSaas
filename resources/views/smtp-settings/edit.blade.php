@extends('layouts.attex.app')

@section('title', 'Configurações SMTP')

@section('content')
@include('partials.attex.page-header', [
    'title' => 'Configurações SMTP',
    'subtitle' => 'Configure o servidor e visualize o e-mail de ativação ao lado',
    'breadcrumbs' => [
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ['label' => 'SMTP'],
    ],
])

<div class="grid xl:grid-cols-2 gap-6 items-stretch">
    <div id="smtp-settings-column" class="space-y-6">
        @include('partials.attex.form-card-open', [
            'formTitle' => 'Servidor SMTP',
            'formSubtitle' => 'Dados do provedor de e-mail (Gmail, Outlook, Amazon SES, etc.)',
            'formAction' => route('smtp.settings.update'),
            'formMethod' => 'PUT',
        ])
            <div class="grid md:grid-cols-2 gap-4">
                <div class="md:col-span-2 flex items-center gap-2">
                    <input type="hidden" name="enabled" value="0">
                    <input type="checkbox" name="enabled" value="1" id="smtp_enabled" class="form-checkbox rounded text-primary" {{ old('enabled', $settings['enabled']) ? 'checked' : '' }}>
                    <label for="smtp_enabled" class="font-semibold text-gray-700 dark:text-gray-300">Habilitar envio por SMTP</label>
                </div>

                <div>
                    <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Host SMTP *</label>
                    <input type="text" name="host" class="form-input" value="{{ old('host', $settings['host']) }}" placeholder="smtp.gmail.com">
                </div>

                <div>
                    <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Porta *</label>
                    <input type="number" name="port" class="form-input" value="{{ old('port', $settings['port']) }}" placeholder="587">
                </div>

                <div>
                    <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Usuário</label>
                    <input type="text" name="username" class="form-input" value="{{ old('username', $settings['username']) }}" placeholder="seu@email.com" autocomplete="off">
                </div>

                <div>
                    <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Senha</label>
                    <input type="password" name="password" class="form-input" placeholder="{{ $settings['password'] ? '•••••••• (deixe em branco para manter)' : 'Senha do SMTP' }}" autocomplete="new-password">
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Para Gmail, use uma senha de app.</p>
                </div>

                <div>
                    <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Criptografia</label>
                    <select name="encryption" class="form-select">
                        @foreach (['tls' => 'TLS (recomendado)', 'ssl' => 'SSL', 'none' => 'Nenhuma'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('encryption', $settings['encryption']) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">E-mail remetente *</label>
                    <input type="email" name="from_address" class="form-input" value="{{ old('from_address', $settings['from_address']) }}" placeholder="noreply@seudominio.com">
                </div>

                <div class="md:col-span-2">
                    <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">Nome remetente</label>
                    <input type="text" name="from_name" class="form-input" value="{{ old('from_name', $settings['from_name']) }}" placeholder="{{ mail_sender_name() }}">
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">Nome exibido como remetente e no corpo dos e-mails (ativação, testes).</p>
                </div>
            </div>
        @include('partials.attex.form-card-close', ['cancelUrl' => route('dashboard'), 'cancelLabel' => 'Voltar', 'submitLabel' => 'Salvar SMTP'])

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Testar Envio</h4>
            </div>
            <div class="p-6">
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Salve as configurações antes de testar. Um e-mail simples será enviado ao endereço informado.</p>
                <form method="POST" action="{{ route('smtp.settings.test') }}" class="flex flex-col sm:flex-row gap-3 items-end">
                    @csrf
                    <div class="grow w-full">
                        <label class="font-semibold text-gray-500 dark:text-gray-400 mb-2 block">E-mail de teste</label>
                        <input type="email" name="test_email" class="form-input" value="{{ old('test_email', auth()->user()->email) }}" required placeholder="seu@email.com">
                    </div>
                    <button type="submit" class="btn bg-info text-white shrink-0">
                        <i class="ri-send-plane-line me-1"></i> Enviar Teste
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div id="smtp-preview-column" class="flex flex-col min-h-0">
        @include('smtp-settings.partials.activation-preview', [
            'previewSubject' => $previewSubject,
            'previewFromName' => $previewFromName,
            'previewFromAddress' => $previewFromAddress,
            'previewSampleEmail' => $previewSampleEmail,
        ])
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        const left = document.getElementById('smtp-settings-column');
        const preview = document.getElementById('smtp-preview-card');

        function syncPreviewHeight() {
            if (!left || !preview) return;

            if (window.matchMedia('(min-width: 1280px)').matches) {
                preview.style.minHeight = left.offsetHeight + 'px';
            } else {
                preview.style.minHeight = '';
            }
        }

        syncPreviewHeight();
        window.addEventListener('resize', syncPreviewHeight);

        if (typeof ResizeObserver !== 'undefined') {
            new ResizeObserver(syncPreviewHeight).observe(left);
        }
    })();
</script>
@endpush