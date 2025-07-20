<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        // Fetch domains assigned to the logged-in customer via their clients
        $clientIds = auth()->user()->clients()->pluck('clients.id');
        $domains = Domain::whereIn('client_id', $clientIds)->get();

        return view('customer.dashboard', compact('domains'));
    }

    public function searchDomains(Request $request)
    {
        // Search within the logged-in customer's domains
        $query = $request->input('query');
        $clientIds = auth()->user()->clients()->pluck('clients.id');
        $domains = Domain::whereIn('client_id', $clientIds)
                         ->where('domain_name', 'LIKE', '%' . $query . '%')
                         ->get();

        return view('customer.dashboard', compact('domains'));
    }
}
