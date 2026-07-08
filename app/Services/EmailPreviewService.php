<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Mail\Markdown;
use Illuminate\Support\Facades\URL;

class EmailPreviewService
{
    public function sampleUser(): User
    {
        $user = new User([
            'name' => 'Usuário Exemplo',
            'email' => 'exemplo@email.com',
        ]);
        $user->id = 1;

        return $user;
    }

    public function verificationUrl(User $user): string
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->getKey(), 'hash' => sha1($user->getEmailForVerification())]
        );
    }

    public function verifyAccountSubject(): string
    {
        return 'Ative sua conta — '.mail_sender_name();
    }

    public function renderVerifyAccountEmail(?User $user = null): string
    {
        $user ??= $this->sampleUser();

        $notification = new VerifyEmailNotification;
        $mail = $notification->toMail($user);

        return app(Markdown::class)->render(
            $mail->markdown,
            $mail->data()
        );
    }
}