@extends('layouts.attex.app')

@section('title', $staff->name)

@section('content')
@include('partials.attex.show-header', [
    'title' => $staff->name,
    'subtitle' => $staff->role->label(),
    'media' => '<img src="'.e(staff_photo_url($staff)).'" alt="'.e($staff->name).'" class="h-16 w-16 rounded-full object-cover border border-gray-200 dark:border-gray-700">',
    'editUrl' => route('staff.edit', $staff),
    'backUrl' => route('staff.index'),
])

<div class="card">
    <div class="card-header">
        <h4 class="card-title">Detalhes do Membro</h4>
    </div>
    <div class="p-6">
        <dl class="grid md:grid-cols-2 gap-6">
            @include('partials.attex.detail-item', ['label' => 'Time', 'value' => $staff->team?->name])
            @include('partials.attex.detail-item', ['label' => 'Clube', 'value' => $staff->club->name])
            @include('partials.attex.detail-item', ['label' => 'Função', 'value' => $staff->role->label()])
            @include('partials.attex.detail-item', ['label' => 'E-mail', 'value' => $staff->email])
            @include('partials.attex.detail-item', ['label' => 'Telefone', 'value' => $staff->phone])
            @include('partials.attex.detail-item', ['label' => 'Status', 'value' => $staff->is_active ? 'Ativo' : 'Inativo'])
            @include('partials.attex.detail-item', ['label' => 'Acesso ao painel', 'value' => $staff->user_id ? 'Criado ('.$staff->user?->email.')' : 'Não criado'])
            @if ($inscriptionEnabled)
                @include('partials.attex.detail-item', [
                    'label' => 'Valor configurado',
                    'value' => 'R$ '.format_brazilian_money($configuredInscriptionAmount),
                ])
            @endif
            @if ($staff->latestInscriptionPayment)
                @include('partials.attex.detail-item', [
                    'label' => 'Cobrança atual',
                    'value' => $staff->latestInscriptionPayment->status->label().' — R$ '.format_brazilian_money($staff->latestInscriptionPayment->amount),
                ])
                @if ($staff->latestInscriptionPayment->paid_at)
                    @include('partials.attex.detail-item', [
                        'label' => 'Pago em',
                        'value' => $staff->latestInscriptionPayment->paid_at->format('d/m/Y H:i'),
                    ])
                @endif
            @endif
        </dl>

        @if ($staff->latestInscriptionPayment?->isPaid())
            <div class="mt-6">
                <a href="{{ route('inscription.payments.receipt', $staff->latestInscriptionPayment) }}" target="_blank" rel="noopener" class="btn btn-sm bg-success text-white">
                    <i class="ri-file-pdf-line me-1"></i> Ver comprovante de inscrição
                </a>
            </div>
        @endif

        @if (
            $inscriptionEnabled
            && $staff->latestInscriptionPayment?->isPending()
            && (float) $staff->latestInscriptionPayment->amount !== (float) $configuredInscriptionAmount
        )
            <div class="mb-4 p-3 rounded-md bg-warning/10 text-warning text-sm">
                A cobrança deste membro ainda está com o valor antigo (R$ {{ format_brazilian_money($staff->latestInscriptionPayment->amount) }}).
                Salve novamente em Pagamentos ou clique em <strong>Gerar nova cobrança de inscrição</strong> para aplicar R$ {{ format_brazilian_money($configuredInscriptionAmount) }}.
            </div>
        @endif

        @if ($inscriptionEnabled && $staff->email)
            <div class="mt-6 flex flex-wrap gap-2">
                <form method="POST" action="{{ route('staff.provision-access', $staff) }}">
                    @csrf
                    <button type="submit" class="btn btn-sm bg-primary text-white">
                        <i class="ri-bank-card-line me-1"></i>
                        {{ $staff->user_id ? 'Gerar nova cobrança de inscrição' : 'Criar acesso e cobrança' }}
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection