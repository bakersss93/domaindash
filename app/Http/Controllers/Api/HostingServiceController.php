<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HostingService;

class HostingServiceController extends Controller
{
    public function index()
    {
        return response()->json(HostingService::with('customer')->get());
    }
}
