<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HaloAPIController extends Controller
{
    public function edit()
    {
        $settings = [
            'api_url' => env('HALO_API_URL'),
            'api_key' => env('HALO_API_KEY'),
        ];

        return view('admin.halo-api.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'api_url' => 'required|string|max:255',
            'api_key' => 'required|string|max:255',
        ]);

        $path = base_path('.env');
        file_put_contents($path, str_replace(
            'HALO_API_URL=' . env('HALO_API_URL'),
            'HALO_API_URL=' . $request->api_url,
            file_get_contents($path)
        ));
        file_put_contents($path, str_replace(
            'HALO_API_KEY=' . env('HALO_API_KEY'),
            'HALO_API_KEY=' . $request->api_key,
            file_get_contents($path)
        ));

        return redirect()->route('halo-api.edit')->with('success', 'Halo API details updated successfully.');
    }
}
