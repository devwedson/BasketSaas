<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>Comprovante {{ $receiptNumber }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1f2937; margin: 0; padding: 0; }
        .header { border-bottom: 3px solid #3e60d5; padding-bottom: 16px; margin-bottom: 24px; }
        .header h1 { font-size: 22px; margin: 0 0 4px; color: #111827; }
        .header p { margin: 0; color: #6b7280; font-size: 11px; }
        .badge { display: inline-block; background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; padding: 6px 12px; border-radius: 999px; font-size: 11px; font-weight: bold; margin-bottom: 20px; }
        .grid { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .grid td { padding: 10px 12px; border: 1px solid #e5e7eb; vertical-align: top; }
        .grid td.label { width: 32%; background: #f9fafb; font-weight: bold; color: #374151; }
        .amount-box { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 16px; margin: 24px 0; text-align: center; }
        .amount-box .value { font-size: 28px; font-weight: bold; color: #1d4ed8; margin-top: 6px; }
        .footer { margin-top: 32px; padding-top: 16px; border-top: 1px solid #e5e7eb; font-size: 10px; color: #9ca3af; text-align: center; line-height: 1.5; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Comprovante de Inscrição</h1>
        <p>{{ $payment->club->name }} · {{ config('app.name') }}</p>
    </div>

    <div class="badge">PAGAMENTO CONFIRMADO</div>

    <table class="grid">
        <tr>
            <td class="label">Nº do comprovante</td>
            <td>{{ $receiptNumber }}</td>
        </tr>
        <tr>
            <td class="label">Data do pagamento</td>
            <td>{{ $payment->paid_at?->timezone(config('app.timezone'))->format('d/m/Y H:i') ?? '—' }}</td>
        </tr>
        <tr>
            <td class="label">Pagador</td>
            <td>{{ $payment->user->name }}<br>{{ $payment->user->email }}</td>
        </tr>
        <tr>
            <td class="label">Profissional</td>
            <td>{{ $payment->staff->name }} · {{ $payment->staff->role->label() }}</td>
        </tr>
        <tr>
            <td class="label">Clube</td>
            <td>{{ $payment->club->name }}</td>
        </tr>
        <tr>
            <td class="label">Descrição</td>
            <td>{{ $description }}</td>
        </tr>
        <tr>
            <td class="label">Forma de pagamento</td>
            <td>Mercado Pago</td>
        </tr>
        @if ($payment->payment_id)
            <tr>
                <td class="label">ID transação Mercado Pago</td>
                <td>{{ $payment->payment_id }}</td>
            </tr>
        @endif
    </table>

    <div class="amount-box">
        <div>Valor pago</div>
        <div class="value">R$ {{ number_format($payment->amount, 2, ',', '.') }}</div>
    </div>

    <div class="footer">
        Documento gerado automaticamente em {{ now()->timezone(config('app.timezone'))->format('d/m/Y H:i') }}.<br>
        Este comprovante comprova o pagamento da inscrição da comissão técnica no {{ config('app.name') }}.
    </div>
</body>
</html>