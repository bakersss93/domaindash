<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Domain;

class DomainApiController extends Controller
{
    public function index()
    {
        return response()->json(Domain::all());
    }

    public function show($id)
    {
        return response()->json(Domain::findOrFail($id));
    }
}
