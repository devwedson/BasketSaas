<?php

namespace App\Http\Controllers;

use App\Services\PaymentSettingsService;
use App\Services\StaffInscriptionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentSettingsController extends Controller
{
    public function edit(PaymentSettingsService $payments): View
    {
        return view('payment-settings.edit', [
            'settings' => $payments->all(),
        ]);
    }

    public function update(
        Request $request,
        PaymentSettingsService $payments,
        StaffInscriptionService $inscriptions
    ): RedirectResponse {
        $request->merge([
            'inscription_amount' => parse_brazilian_money($request->input('inscription_amount')),
        ]);

        $data = $request->validate([
            'inscription_enabled' => ['nullable', 'boolean'],
            'inscription_amount' => ['required_if:inscription_enabled,1', 'nullable', 'numeric', 'min:1'],
            'inscription_description' => ['nullable', 'string', 'max:255'],
            'public_key' => ['nullable', 'string', 'max:255'],
            'access_token' => ['nullable', 'string', 'max:255'],
            'sandbox' => ['nullable', 'boolean'],
        ]);

        $payments->save($data);
        $payments->applyToConfig();

        $synced = $inscriptions->syncPendingAmountsToSettings();

        $message = 'Configurações de pagamento salvas com sucesso.';

        if ($synced > 0) {
            $message .= " {$synced} cobrança(s) pendente(s) atualizada(s) para o novo valor.";
        }

        return redirect()
            ->route('payment.settings.edit')
            ->with('success', $message);
    }
}