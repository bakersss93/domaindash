<?php

namespace Tests\Feature;

use App\Models\SMTPSetting;
use App\Models\User;
use App\Mail\TestEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SMTPSettingsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_update_changes_runtime_configuration(): void
    {
        SMTPSetting::create([
            'send_from_email' => 'old@example.com',
            'smtp_server' => 'old.server',
            'smtp_port' => 25,
            'smtp_username' => 'olduser',
            'smtp_password' => 'oldpass',
        ]);

        $this->actingAs(User::factory()->make(['id' => 1, 'role' => 'admin']));

        $this->put(route('smtp-settings.update', 1), [
            'send_from_email' => 'new@example.com',
            'smtp_server' => 'smtp.example.com',
            'smtp_port' => 2525,
            'smtp_username' => 'user',
            'smtp_password' => 'pass',
        ])->assertRedirect(route('smtp-settings.edit', 1));

        $this->assertSame('smtp.example.com', Config::get('mail.mailers.smtp.host'));
        $this->assertSame(2525, Config::get('mail.mailers.smtp.port'));
        $this->assertSame('user', Config::get('mail.mailers.smtp.username'));
        $this->assertSame('pass', Config::get('mail.mailers.smtp.password'));
        $this->assertSame('new@example.com', Config::get('mail.from.address'));
    }

    public function test_send_test_email_dispatches_mailable(): void
    {
        Mail::fake();

        SMTPSetting::create([
            'send_from_email' => 'from@example.com',
            'smtp_server' => 'smtp.example.com',
            'smtp_port' => 2525,
            'smtp_username' => 'user',
            'smtp_password' => 'pass',
        ]);

        $this->actingAs(User::factory()->make(['id' => 1, 'role' => 'admin']));

        $this->post(route('smtp-settings.test-email'), [
            'email' => 'dest@example.com',
        ])->assertRedirect();

        Mail::assertSent(TestEmail::class, function (TestEmail $mail) {
            return in_array('dest@example.com', array_column($mail->to, 'address'));
        });
    }
}
