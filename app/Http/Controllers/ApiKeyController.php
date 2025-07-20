<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiKey;
use Illuminate\Support\Str;

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

    public function edit($id)
    {
        $apiKey = ApiKey::findOrFail($id);
        return view('admin.api-keys.edit', compact('apiKey'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'key_name' => 'required|string|max:255',
            'permissions' => 'required|in:read-only,read-write',
            'allowed_ips' => 'nullable|string',
            'rate_limit' => 'required|integer|min:1',
        ]);

        $plainToken = Str::random(32);

        ApiKey::create([
            'key_name' => $request->key_name,
            'description' => $request->description,
            'hashed_key' => hash('sha256', $plainToken),
            'permissions' => $request->permissions,
            'allowed_ips' => $request->allowed_ips,
            'rate_limit' => $request->rate_limit,
            'expires_at' => $request->expires_at,
        ]);

        return redirect()->route('api-keys.index')
            ->with('success', 'API key created successfully.')
            ->with('plainToken', $plainToken);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'key_name' => 'required|string|max:255',
            'permissions' => 'required|in:read-only,read-write',
            'allowed_ips' => 'nullable|string',
            'rate_limit' => 'required|integer|min:1',
        ]);

        $apiKey = ApiKey::findOrFail($id);
        $apiKey->update($request->only(['key_name','description','permissions','allowed_ips','rate_limit','expires_at']));

        return redirect()->route('api-keys.index')->with('success', 'API key updated successfully.');
    }

    public function destroy($id)
    {
        $apiKey = ApiKey::findOrFail($id);
        $apiKey->delete();

        return redirect()->route('api-keys.index')->with('success', 'API key deleted successfully.');
    }
}
