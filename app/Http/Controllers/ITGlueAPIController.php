<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ITGlueAPIController extends Controller
{
    public function edit()
    {
        $settings = [
            'api_url' => env('ITGLUE_API_URL'),
            'api_key' => env('ITGLUE_API_KEY'),
        ];

        return view('admin.itglue-api.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'api_url' => 'required|string|max:255',
            'api_key' => 'required|string|max:255',
        ]);

        $path = base_path('.env');
        file_put_contents($path, str_replace(
            'ITGLUE_API_URL=' . env('ITGLUE_API_URL'),
            'ITGLUE_API_URL=' . $request->api_url,
            file_get_contents($path)
        ));
        file_put_contents($path, str_replace(
            'ITGLUE_API_KEY=' . env('ITGLUE_API_KEY'),
            'ITGLUE_API_KEY=' . $request->api_key,
            file_get_contents($path)
        ));

        return redirect()->route('itglue-api.edit')->with('success', 'ITGlue API details updated successfully.');
    }
}
