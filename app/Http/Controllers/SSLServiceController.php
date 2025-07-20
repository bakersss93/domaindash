<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SSLService;
use App\Models\User;

class SSLServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sslServices = SSLService::with('customer')->get();
        return view('ssl-services.index', compact('sslServices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = User::all();
        return view('ssl-services.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'certificate_name' => 'required|string|max:255',
            'customer_id' => 'nullable|exists:users,id',
            'expiration_date' => 'required|date',
            'details' => 'nullable|string',
        ]);

        $service = SSLService::create($data);

        if ($service->customer_id) {
            try {
                app(\App\Services\HaloClient::class)->upsertAsset([
                    'name' => $service->certificate_name,
                    'type' => 'SSL',
                    'client_id' => $service->customer_id,
                ]);
                app(\App\Services\ITGlueClient::class)->upsertConfiguration([
                    'name' => $service->certificate_name,
                    'type' => 'SSL',
                    'client_id' => $service->customer_id,
                ]);
            } catch (\Exception $e) {
                \Log::error('Integration sync failed: '.$e->getMessage());
            }
        }

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
        $customers = User::all();
        return view('ssl-services.edit', compact('sslService', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'certificate_name' => 'required|string|max:255',
            'customer_id' => 'nullable|exists:users,id',
            'expiration_date' => 'required|date',
            'details' => 'nullable|string',
        ]);

        $sslService = SSLService::findOrFail($id);
        $sslService->update($data);

        if ($sslService->customer_id) {
            try {
                app(\App\Services\HaloClient::class)->upsertAsset([
                    'name' => $sslService->certificate_name,
                    'type' => 'SSL',
                    'client_id' => $sslService->customer_id,
                ]);
                app(\App\Services\ITGlueClient::class)->upsertConfiguration([
                    'name' => $sslService->certificate_name,
                    'type' => 'SSL',
                    'client_id' => $sslService->customer_id,
                ]);
            } catch (\Exception $e) {
                \Log::error('Integration sync failed: '.$e->getMessage());
            }
        }

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
