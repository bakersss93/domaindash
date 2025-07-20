<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Domain;
use App\Models\Client;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $domains = Domain::with('client')->get();
        return view('domains.index', compact('domains'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all();
        return view('domains.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'domain_name' => 'required|string|max:255',
            'client_id' => 'nullable|exists:clients,id',
            'auto_renew' => 'boolean',
            'renewal_date' => 'nullable|date',
        ]);

        Domain::create($data);

        return redirect()->route('domains.index')->with('success', 'Domain created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $domain = Domain::findOrFail($id);
        $clients = Client::all();
        return view('domains.edit', compact('domain', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'domain_name' => 'required|string|max:255',
            'client_id' => 'nullable|exists:clients,id',
            'auto_renew' => 'boolean',
            'renewal_date' => 'nullable|date',
        ]);

        $domain = Domain::findOrFail($id);
        $domain->update($data);

        return redirect()->route('domains.index')->with('success', 'Domain updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $domain = Domain::findOrFail($id);
        $domain->delete();

        return redirect()->route('domains.index')->with('success', 'Domain deleted successfully.');
    }
}
