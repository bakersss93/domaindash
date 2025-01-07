<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiKey;

class ApiKeyController extends Controller
{
    public function index()
    {
        $apiKeys = ApiKey::all();
        return view('admin.api-keys.index', compact('apiKeys'));
    }

    public function create()
    {
        return view('admin.api-keys.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'key_name' => 'required|string|max:255',
            'permissions' => 'required|in:read-only,read-write',
            'allowed_ips' => 'nullable|string',
            'rate_limit' => 'required|integer|min:1',
        ]);

        ApiKey::create([
            'key_name' => $request->key_name,
            'description' => $request->description,
            'hashed_key' => hash('sha256', uniqid()),
            'permissions' => $request->permissions,
            'allowed_ips' => $request->allowed_ips,
            'rate_limit' => $request->rate_limit,
            'expires_at' => $request->expires_at,
        ]);

        return redirect()->route('api-keys.index')->with('success', 'API key created successfully.');
    }

    public function destroy($id)
    {
        $apiKey = ApiKey::findOrFail($id);
        $apiKey->delete();

        return redirect()->route('api-keys.index')->with('success', 'API key deleted successfully.');
    }
}
