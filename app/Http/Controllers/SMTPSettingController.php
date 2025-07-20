<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;
use App\Models\SMTPSetting;

class SMTPSettingController extends Controller
{
    public function edit()
    {
        $settings = SMTPSetting::first();
        return view('admin.smtp-settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'send_from_email' => 'required|email',
            'smtp_server' => 'required|string|max:255',
            'smtp_port' => 'required|integer',
            'smtp_username' => 'required|string|max:255',
            'smtp_password' => 'required|string|max:255',
        ]);

        $settings = SMTPSetting::first();
        $settings->update($request->all());

        Config::set('mail.mailers.smtp.host', $settings->smtp_server);
        Config::set('mail.mailers.smtp.port', $settings->smtp_port);
        Config::set('mail.mailers.smtp.username', $settings->smtp_username);
        Config::set('mail.mailers.smtp.password', $settings->smtp_password);
        Config::set('mail.from.address', $settings->send_from_email);

        return redirect()
            ->route('smtp-settings.edit', $settings->id)
            ->with('success', 'SMTP settings updated successfully.');
    }

    public function sendTestEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $settings = SMTPSetting::first();
        if ($settings) {
            Config::set('mail.mailers.smtp.host', $settings->smtp_server);
            Config::set('mail.mailers.smtp.port', $settings->smtp_port);
            Config::set('mail.mailers.smtp.username', $settings->smtp_username);
            Config::set('mail.mailers.smtp.password', $settings->smtp_password);
            Config::set('mail.from.address', $settings->send_from_email);
        }

        Mail::to($request->email)->send(new TestEmail());

        return back()->with('success', 'Test email sent successfully.');
    }
}
