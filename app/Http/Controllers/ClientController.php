<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'business_name' => 'required|string|max:255',
            'abn' => 'nullable|string|max:255',
            'halopsa_reference' => 'nullable|string|max:255',
            'itglue_org_id' => 'nullable|integer',
            'active' => 'boolean',
        ]);

        Client::create($data);

        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
    }

    public function edit(string $id)
    {
        $client = Client::findOrFail($id);
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'business_name' => 'required|string|max:255',
            'abn' => 'nullable|string|max:255',
            'halopsa_reference' => 'nullable|string|max:255',
            'itglue_org_id' => 'nullable|integer',
            'active' => 'boolean',
        ]);

        $client = Client::findOrFail($id);
        $client->update($data);

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    public function destroy(string $id)
    {
        $client = Client::findOrFail($id);
        $client->delete();

        return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');
    }
}
