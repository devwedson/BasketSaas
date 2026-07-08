<?php

namespace App\Http\Controllers;

use App\Services\PaymentSettingsService;
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

    public function update(Request $request, PaymentSettingsService $payments): RedirectResponse
    {
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

        return redirect()
            ->route('payment.settings.edit')
            ->with('success', 'Configurações de pagamento salvas com sucesso.');
    }
}