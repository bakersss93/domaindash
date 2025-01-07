<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        return redirect()->route('smtp-settings.edit')->with('success', 'SMTP settings updated successfully.');
    }
}
