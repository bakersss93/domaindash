<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        // Fetch domains assigned to the logged-in customer
        $domains = Domain::where('customer_id', auth()->id())->get();

        return view('customer.dashboard', compact('domains'));
    }

    public function searchDomains(Request $request)
    {
        // Search within the logged-in customer's domains
        $query = $request->input('query');
        $domains = Domain::where('customer_id', auth()->id())
                         ->where('domain_name', 'LIKE', '%' . $query . '%')
                         ->get();

        return view('customer.dashboard', compact('domains'));
    }
}
