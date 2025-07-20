<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DarkModeController extends Controller
{
    public function toggle()
    {
        $user = auth()->user();
        $user->dark_mode = ! $user->dark_mode;
        $user->save();

        return back();
    }
}
