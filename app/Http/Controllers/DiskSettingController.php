<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiskSetting;

class DiskSettingController extends Controller
{
    public function edit()
    {
        $settings = DiskSetting::first();
        return view('admin.disk-settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'warning_threshold' => 'required|integer|min:1',
        ]);

        $settings = DiskSetting::first();
        $settings->update($request->only('warning_threshold'));

        return redirect()->route('disk-settings.edit')->with('success', 'Disk settings updated successfully.');
    }
}
