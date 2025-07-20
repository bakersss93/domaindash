<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Models\Backup;

class BackupController extends Controller
{
    public function index()
    {
        $backups = Backup::latest()->get();
        return view('admin.backups.index', compact('backups'));
    }

    public function store()
    {
        Artisan::call('backup:run');
        return redirect()->route('backups.index')->with('success', 'Backup started.');
    }
}
