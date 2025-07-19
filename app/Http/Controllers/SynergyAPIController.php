<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SynergyCredential;

class SynergyAPIController extends Controller
{
    public function edit()
    {
        $credentials = SynergyCredential::first();
        $settings = [
            'reseller_id' => $credentials->reseller_id ?? '',
            'api_key' => $credentials->api_key ?? '',
        ];

        return view('admin.synergy-api.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'reseller_id' => 'required|string|max:255',
            'api_key' => 'required|string|max:255',
        ]);

        $credential = SynergyCredential::first();
        if ($credential) {
            $credential->update([
                'reseller_id' => $request->reseller_id,
                'api_key' => $request->api_key,
            ]);
        } else {
            SynergyCredential::create([
                'reseller_id' => $request->reseller_id,
                'api_key' => $request->api_key,
            ]);
        }

        return redirect()->route('synergy-api.edit')->with('success', 'Synergy API details updated successfully.');
    }
}
