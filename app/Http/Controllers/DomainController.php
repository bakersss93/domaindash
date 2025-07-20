<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Domain;
use App\Models\User;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $domains = Domain::with('customer')->get();
        return view('domains.index', compact('domains'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = User::all();
        return view('domains.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'domain_name' => 'required|string|max:255',
            'customer_id' => 'nullable|exists:users,id',
            'auto_renew' => 'boolean',
            'renewal_date' => 'nullable|date',
        ]);

        $domain = Domain::create($data);

        if ($domain->customer_id) {
            try {
                app(\App\Services\HaloClient::class)->upsertAsset([
                    'name' => $domain->domain_name,
                    'type' => 'Domain',
                    'client_id' => $domain->customer_id,
                ]);
                app(\App\Services\ITGlueClient::class)->upsertConfiguration([
                    'name' => $domain->domain_name,
                    'type' => 'Domain',
                    'client_id' => $domain->customer_id,
                ]);
            } catch (\Exception $e) {
                \Log::error('Integration sync failed: '.$e->getMessage());
            }
        }

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
        $customers = User::all();
        return view('domains.edit', compact('domain', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'domain_name' => 'required|string|max:255',
            'customer_id' => 'nullable|exists:users,id',
            'auto_renew' => 'boolean',
            'renewal_date' => 'nullable|date',
        ]);

        $domain = Domain::findOrFail($id);
        $domain->update($data);

        if ($domain->customer_id) {
            try {
                app(\App\Services\HaloClient::class)->upsertAsset([
                    'name' => $domain->domain_name,
                    'type' => 'Domain',
                    'client_id' => $domain->customer_id,
                ]);
                app(\App\Services\ITGlueClient::class)->upsertConfiguration([
                    'name' => $domain->domain_name,
                    'type' => 'Domain',
                    'client_id' => $domain->customer_id,
                ]);
            } catch (\Exception $e) {
                \Log::error('Integration sync failed: '.$e->getMessage());
            }
        }

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
