<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Notifications\VerifyEmailNotification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SmtpSenderNameTest extends TestCase
{
    use RefreshDatabase;

    public function test_mail_sender_name_uses_smtp_from_name_setting(): void
    {
        Setting::query()->create(['key' => 'smtp.from_name', 'value' => 'Neodunk LIBCE']);

        $this->assertSame('Neodunk LIBCE', mail_sender_name());
    }

    public function test_verify_email_notification_uses_configured_sender_name(): void
    {
        Setting::query()->create(['key' => 'smtp.from_name', 'value' => 'Clube Neodunk']);
        Setting::query()->create(['key' => 'smtp.from_address', 'value' => 'noreply@libce.com.br']);
        Setting::query()->create(['key' => 'smtp.enabled', 'value' => '1']);
        Setting::query()->create(['key' => 'smtp.host', 'value' => 'smtp.test.com']);

        $user = User::factory()->create(['name' => 'Técnico Teste']);
        $mail = (new VerifyEmailNotification)->toMail($user);

        $this->assertStringContainsString('Clube Neodunk', $mail->subject);
        $this->assertSame('Clube Neodunk', $mail->viewData['appName']);
    }
}