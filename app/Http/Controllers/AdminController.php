<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminController extends Controller
{
    public function impersonate($id)
    {
        $user = User::findOrFail($id);
        auth()->login($user);
        return redirect()->route('dashboard')->with('success', 'Impersonation started.');
    }
}
