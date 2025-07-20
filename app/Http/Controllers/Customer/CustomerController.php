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

}
