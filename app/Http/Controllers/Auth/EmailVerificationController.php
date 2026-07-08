<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\SmtpSettingsService;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailVerificationController extends Controller
{
    public function notice(SmtpSettingsService $smtp): View
    {
        return view('auth.verify-email', [
            'smtpConfigured' => $smtp->isConfigured(),
        ]);
    }

    public function verify(EmailVerificationRequest $request): RedirectResponse
    {
        $request->fulfill();

        return redirect()
            ->route('dashboard')
            ->with('success', 'E-mail confirmado com sucesso! Bem-vindo ao painel.');
    }

    public function resend(Request $request, SmtpSettingsService $smtp): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('dashboard');
        }

        if (! $smtp->isConfigured()) {
            return back()->withErrors([
                'email' => 'O envio de e-mails ainda não está configurado. Entre em contato com o administrador.',
            ]);
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Um novo link de ativação foi enviado para seu e-mail.');
    }
}