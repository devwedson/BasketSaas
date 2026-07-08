<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SmtpSettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request, SmtpSettingsService $smtp): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => UserRole::Club,
            'is_active' => true,
        ]);

        Auth::login($user);

        if ($smtp->isConfigured()) {
            $user->sendEmailVerificationNotification();
        }

        return redirect()
            ->route('verification.notice')
            ->with($smtp->isConfigured() ? 'success' : 'warning', $smtp->isConfigured()
                ? 'Conta criada! Verifique seu e-mail para ativar o acesso.'
                : 'Conta criada. O administrador ainda precisa configurar o SMTP para enviar o e-mail de ativação.');
    }
}