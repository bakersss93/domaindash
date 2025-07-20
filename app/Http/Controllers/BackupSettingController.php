<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BackupSetting;

class BackupSettingController extends Controller
{
    public function edit()
    {
        $settings = BackupSetting::first();
        return view('admin.backup-settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'sftp_server' => 'required|string|max:255',
            'sftp_port' => 'required|integer',
            'sftp_username' => 'required|string|max:255',
            'sftp_password' => 'required|string|max:255',
            'backup_retention' => 'required|integer|min:1',
            'backup_time' => 'required',
        ]);

        $settings = BackupSetting::first();
        $settings->update($request->all());

        return redirect()->route('backup-settings.edit')->with('success', 'Backup settings updated successfully.');
    }
}
