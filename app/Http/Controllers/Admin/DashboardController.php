<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SystemMetric;
use App\Models\SystemStatus;
use App\Services\SynergyClient;

class DashboardController extends Controller
{
    private SynergyClient $synergy;

    public function __construct(SynergyClient $synergy)
    {
        $this->synergy = $synergy;
    }

    public function index()
    {
        $metrics = [
            'storage' => SystemMetric::where('metric_type', 'storage')->orderBy('recorded_at', 'desc')->limit(30)->get(),
            'cpu' => SystemMetric::where('metric_type', 'cpu')->orderBy('recorded_at', 'desc')->limit(30)->get(),
            'memory' => SystemMetric::where('metric_type', 'memory')->orderBy('recorded_at', 'desc')->limit(30)->get(),
            'database' => SystemMetric::where('metric_type', 'database')->orderBy('recorded_at', 'desc')->limit(30)->get(),
        ];

        $status = SystemStatus::first();

        $balanceResponse = $this->synergy->getAccountBalance();
        $balance = $balanceResponse['balance'] ?? null;

        return view('admin.dashboard', compact('metrics', 'status', 'balance'));
    }
}
