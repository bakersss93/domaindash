<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = Setting::first();
        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'primary_color' => 'required|string',
            'secondary_color' => 'required|string',
            'logo' => 'nullable|image',
        ]);

        $settings = Setting::first();

        $data = $request->only('primary_color', 'secondary_color');

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $data['logo_path'] = $path;
        }

        $settings->update($data);

        return redirect()->route('settings.edit')->with('success', 'Settings updated successfully.');
    }
}
