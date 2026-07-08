<?php

namespace App\Http\Controllers;

use App\Services\EmailPreviewService;
use App\Services\SmtpSettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class SmtpSettingsController extends Controller
{
    public function edit(SmtpSettingsService $smtp, EmailPreviewService $preview): View
    {
        $settings = $smtp->all();

        return view('smtp-settings.edit', [
            'settings' => $settings,
            'previewSubject' => $preview->verifyAccountSubject(),
            'previewFromAddress' => $settings['from_address'] ?: config('mail.from.address'),
            'previewFromName' => $smtp->senderName(),
            'previewSampleEmail' => $preview->sampleUser()->email,
        ]);
    }

    public function update(Request $request, SmtpSettingsService $smtp): RedirectResponse
    {
        $data = $request->validate([
            'enabled' => ['nullable', 'boolean'],
            'host' => ['required_if:enabled,1', 'nullable', 'string', 'max:255'],
            'port' => ['required_if:enabled,1', 'nullable', 'integer', 'min:1', 'max:65535'],
            'username' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'max:255'],
            'encryption' => ['nullable', 'in:tls,ssl,none'],
            'from_address' => ['required_if:enabled,1', 'nullable', 'email', 'max:255'],
            'from_name' => ['nullable', 'string', 'max:255'],
        ]);

        $smtp->save($data);
        $smtp->applyToConfig();

        return redirect()
            ->route('smtp.settings.edit')
            ->with('success', 'Configurações SMTP salvas com sucesso.');
    }

    public function test(Request $request, SmtpSettingsService $smtp): RedirectResponse
    {
        $data = $request->validate([
            'test_email' => ['required', 'email'],
        ]);

        $smtp->applyToConfig();

        if (! $smtp->isConfigured()) {
            return back()->withErrors([
                'test_email' => 'Salve e habilite o SMTP antes de enviar o teste.',
            ]);
        }

        try {
            $senderName = $smtp->senderName();

            Mail::raw(
                'Este é um e-mail de teste do '.$senderName.".\n\nSe você recebeu esta mensagem, o SMTP está configurado corretamente.",
                function ($message) use ($data, $smtp, $senderName) {
                    $settings = $smtp->all();
                    $message->to($data['test_email'])
                        ->subject('Teste SMTP — '.$senderName)
                        ->from($settings['from_address'], $senderName);
                }
            );
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->withErrors(['test_email' => 'Falha ao enviar: '.$e->getMessage()]);
        }

        return back()->with('success', 'E-mail de teste enviado para '.$data['test_email'].'.');
    }

    public function previewActivation(): RedirectResponse
    {
        return redirect()->route('smtp.settings.edit');
    }

    public function previewActivationFrame(EmailPreviewService $preview)
    {
        return response($preview->renderVerifyAccountEmail())
            ->header('Content-Type', 'text/html; charset=UTF-8');
    }
}