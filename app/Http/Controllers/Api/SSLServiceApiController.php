<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SSLService;

class SSLServiceApiController extends Controller
{
    public function index()
    {
        return response()->json(SSLService::all());
    }

    public function show($id)
    {
        return response()->json(SSLService::findOrFail($id));
    }
}
