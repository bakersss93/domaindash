<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Domain;
use App\Models\HostingService;
use App\Models\SSLService;
use App\Models\User;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $status = $request->input('status');
        $serviceType = $request->input('service_type');
        $tag = $request->input('tag');

        $domains = Domain::query();
        if (auth()->user()->role === 'customer') {
            $domains->where('customer_id', auth()->id());
        }
        if ($query) {
            $domains->where('domain_name', 'like', "%{$query}%");
        }
        if ($status && $domains->getModel()->isFillable('status')) {
            $domains->where('status', $status);
        }
        if ($tag && $domains->getModel()->isFillable('tag')) {
            $domains->where('tag', $tag);
        }
        $domains = $domains->get();

        $hostingServices = HostingService::query();
        if (auth()->user()->role === 'customer') {
            $hostingServices->where('customer_id', auth()->id());
        }
        if ($query) {
            $hostingServices->where('service_name', 'like', "%{$query}%");
        }
        if ($serviceType && $hostingServices->getModel()->isFillable('service_type')) {
            $hostingServices->where('service_type', $serviceType);
        } elseif ($serviceType) {
            $hostingServices->where('hosting_plan', $serviceType);
        }
        if ($status && $hostingServices->getModel()->isFillable('status')) {
            $hostingServices->where('status', $status);
        }
        if ($tag && $hostingServices->getModel()->isFillable('tag')) {
            $hostingServices->where('tag', $tag);
        }
        $hostingServices = $hostingServices->get();

        $sslServices = SSLService::query();
        if (auth()->user()->role === 'customer') {
            $sslServices->where('customer_id', auth()->id());
        }
        if ($query) {
            $sslServices->where('certificate_name', 'like', "%{$query}%");
        }
        if ($status && $sslServices->getModel()->isFillable('status')) {
            $sslServices->where('status', $status);
        }
        if ($serviceType && $sslServices->getModel()->isFillable('service_type')) {
            $sslServices->where('service_type', $serviceType);
        }
        if ($tag && $sslServices->getModel()->isFillable('tag')) {
            $sslServices->where('tag', $tag);
        }
        $sslServices = $sslServices->get();

        $clients = collect();
        if (auth()->user()->role === 'admin') {
            $clientsQuery = User::query()->where('role', 'customer');
            if ($query) {
                $clientsQuery->where(function ($q) use ($query) {
                    $q->where('first_name', 'like', "%{$query}%")
                      ->orWhere('surname', 'like', "%{$query}%")
                      ->orWhere('email', 'like', "%{$query}%");
                });
            }
            if ($status && $clientsQuery->getModel()->isFillable('status')) {
                $clientsQuery->where('status', $status);
            }
            if ($tag && $clientsQuery->getModel()->isFillable('tag')) {
                $clientsQuery->where('tag', $tag);
            }
            $clients = $clientsQuery->get();
        }

        return view('search.index', compact('domains', 'hostingServices', 'sslServices', 'clients', 'query', 'status', 'serviceType', 'tag'));
    }
}
