<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HostingService;
use App\Models\User;
use App\Services\SynergyClient;

class HostingServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hostingServices = HostingService::with('customer')->get();
        return view('hosting-services.index', compact('hostingServices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = User::all();
        return view('hosting-services.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'service_name' => 'required|string|max:255',
            'customer_id' => 'nullable|exists:users,id',
            'disk_usage' => 'nullable|integer',
            'database_usage' => 'nullable|integer',
            'disk_space_threshold' => 'nullable|integer',
            'hosting_plan' => 'required|string',
        ]);

        HostingService::create($data);

        return redirect()->route('hosting-services.index')->with('success', 'Hosting service created successfully.');
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
        $hostingService = HostingService::findOrFail($id);
        $customers = User::all();
        return view('hosting-services.edit', compact('hostingService', 'customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'service_name' => 'required|string|max:255',
            'customer_id' => 'nullable|exists:users,id',
            'disk_usage' => 'nullable|integer',
            'database_usage' => 'nullable|integer',
            'disk_space_threshold' => 'nullable|integer',
            'hosting_plan' => 'required|string',
        ]);

        $hostingService = HostingService::findOrFail($id);
        $hostingService->update($data);

        return redirect()->route('hosting-services.index')->with('success', 'Hosting service updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $hostingService = HostingService::findOrFail($id);
        $hostingService->delete();

        return redirect()->route('hosting-services.index')->with('success', 'Hosting service deleted successfully.');
    }

    /**
     * Redirect to the cPanel login URL for the hosting service.
     */
    public function cpanel(string $id, SynergyClient $synergy)
    {
        $service = HostingService::findOrFail($id);
        $response = $synergy->hostingGetLogin($service->id);

        if (isset($response['loginUrl'])) {
            return redirect()->away($response['loginUrl']);
        }

        return back()->with('error', 'Unable to generate cPanel login link.');
    }
}
