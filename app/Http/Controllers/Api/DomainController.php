<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Domain;

class DomainController extends Controller
{
    public function index()
    {
        return response()->json(Domain::with('customer')->get());
    }
}
