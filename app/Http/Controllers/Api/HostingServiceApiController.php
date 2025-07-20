<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HostingService;

class HostingServiceApiController extends Controller
{
    public function index()
    {
        return response()->json(HostingService::all());
    }

    public function show($id)
    {
        return response()->json(HostingService::findOrFail($id));
    }
}
