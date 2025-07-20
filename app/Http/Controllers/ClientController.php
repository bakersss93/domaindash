<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with('users')->get();
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        $users = User::all();
        return view('clients.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'business_name' => 'required|string|max:255',
            'abn' => 'nullable|string|max:255',
            'halo_reference' => 'nullable|string|max:255',
            'itglue_org_id' => 'nullable|integer',
            'active' => 'boolean',
            'users' => 'array',
            'users.*' => 'exists:users,id',
        ]);

        $client = Client::create($data);
        if (isset($data['users'])) {
            $client->users()->sync($data['users']);
        }

        return redirect()->route('clients.index')
            ->with('success', 'Client created successfully.');
    }

    public function show(string $id)
    {
        $client = Client::with('users')->findOrFail($id);
        return view('clients.show', compact('client'));
    }

    public function edit(string $id)
    {
        $client = Client::findOrFail($id);
        $users = User::all();
        $assigned = $client->users->pluck('id')->toArray();
        return view('clients.edit', compact('client', 'users', 'assigned'));
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'business_name' => 'required|string|max:255',
            'abn' => 'nullable|string|max:255',
            'halo_reference' => 'nullable|string|max:255',
            'itglue_org_id' => 'nullable|integer',
            'active' => 'boolean',
            'users' => 'array',
            'users.*' => 'exists:users,id',
        ]);

        $client = Client::findOrFail($id);
        $client->update($data);
        $client->users()->sync($data['users'] ?? []);

        return redirect()->route('clients.index')
            ->with('success', 'Client updated successfully.');
    }

    public function destroy(string $id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Client deleted successfully.');
    }
}
