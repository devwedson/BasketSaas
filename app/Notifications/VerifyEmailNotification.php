<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends VerifyEmail
{
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Ative sua conta — '.config('app.name'))
            ->markdown('emails.verify-account', [
                'name' => $notifiable->name,
                'appName' => config('app.name'),
                'verificationUrl' => $this->verificationUrl($notifiable),
            ]);
    }
}