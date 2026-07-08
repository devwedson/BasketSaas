<?php

namespace App\Notifications;

use App\Services\SmtpSettingsService;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends VerifyEmail
{
    public function toMail($notifiable): MailMessage
    {
        $smtp = app(SmtpSettingsService::class);
        $settings = $smtp->all();
        $senderName = $smtp->senderName();

        $message = (new MailMessage)
            ->subject('Ative sua conta — '.$senderName)
            ->markdown('emails.verify-account', [
                'name' => $notifiable->name,
                'appName' => $senderName,
                'verificationUrl' => $this->verificationUrl($notifiable),
            ]);

        if ($smtp->isConfigured()) {
            $message->from($settings['from_address'], $senderName);
        }

        return $message;
    }
}