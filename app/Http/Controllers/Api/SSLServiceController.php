<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SSLService;

class SSLServiceController extends Controller
{
    public function index()
    {
        return response()->json(SSLService::with('customer')->get());
    }
}
