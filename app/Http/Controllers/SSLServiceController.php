<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SSLService;
use App\Models\Client;

class SSLServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sslServices = SSLService::with('client')->get();
        return view('ssl-services.index', compact('sslServices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::all();
        return view('ssl-services.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'certificate_name' => 'required|string|max:255',
            'client_id' => 'nullable|exists:clients,id',
            'expiration_date' => 'required|date',
            'details' => 'nullable|string',
        ]);

        SSLService::create($data);

        return redirect()->route('ssl-services.index')->with('success', 'SSL service created successfully.');
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
        $sslService = SSLService::findOrFail($id);
        $clients = Client::all();
        return view('ssl-services.edit', compact('sslService', 'clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'certificate_name' => 'required|string|max:255',
            'client_id' => 'nullable|exists:clients,id',
            'expiration_date' => 'required|date',
            'details' => 'nullable|string',
        ]);

        $sslService = SSLService::findOrFail($id);
        $sslService->update($data);

        return redirect()->route('ssl-services.index')->with('success', 'SSL service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sslService = SSLService::findOrFail($id);
        $sslService->delete();

        return redirect()->route('ssl-services.index')->with('success', 'SSL service deleted successfully.');
    }
}
