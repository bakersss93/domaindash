<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SynergyAPIController extends Controller
{
    public function edit()
    {
        $settings = [
            'reseller_id' => env('SYNERGY_RESELLER_ID'),
            'api_key' => env('SYNERGY_API_KEY'),
        ];

        return view('admin.synergy-api.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'reseller_id' => 'required|string|max:255',
            'api_key' => 'required|string|max:255',
        ]);

        // Update .env file
        $path = base_path('.env');
        file_put_contents($path, str_replace(
            'SYNERGY_RESELLER_ID=' . env('SYNERGY_RESELLER_ID'),
            'SYNERGY_RESELLER_ID=' . $request->reseller_id,
            file_get_contents($path)
        ));
        file_put_contents($path, str_replace(
            'SYNERGY_API_KEY=' . env('SYNERGY_API_KEY'),
            'SYNERGY_API_KEY=' . $request->api_key,
            file_get_contents($path)
        ));

        return redirect()->route('synergy-api.edit')->with('success', 'Synergy API details updated successfully.');
    }
}
