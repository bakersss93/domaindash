@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Welcome, {{ auth()->user()->first_name }}</h1>

<div class="grid grid-cols-2 gap-6">
    @if(auth()->user()->can('manage users'))
        <div class="bg-white shadow rounded p-4">
            <h2 class="text-xl font-bold">Users</h2>
            <p>Manage platform users and their roles.</p>
            <a href="{{ route('users.index') }}" class="text-blue-500">Go to Users</a>
        </div>
        <div class="bg-white shadow rounded p-4">
            <h2 class="text-xl font-bold">Email Templates</h2>
            <p>Customize email notifications.</p>
            <a href="{{ route('email-templates.index') }}" class="text-blue-500">Go to Email Templates</a>
        </div>
        <div class="bg-white shadow rounded p-4">
            <h2 class="text-xl font-bold">API Keys</h2>
            <p>Manage API keys for third-party integrations.</p>
            <a href="{{ route('api-keys.index') }}" class="text-blue-500">Go to API Keys</a>
        </div>
    @endif

    @if(auth()->user()->hasRole('Customer'))
        <div class="bg-white shadow rounded p-4">
            <h2 class="text-xl font-bold">My Domains</h2>
            <p>View and manage your assigned domains.</p>
            <a href="{{ route('customer.domains.index') }}" class="text-blue-500">View Domains</a>
        </div>
        <div class="bg-white shadow rounded p-4">
            <h2 class="text-xl font-bold">My Hosting</h2>
            <p>View and manage your hosting services.</p>
            <a href="{{ route('customer.hosting.index') }}" class="text-blue-500">View Hosting</a>
        </div>
        <div class="bg-white shadow rounded p-4">
            <h2 class="text-xl font-bold">My SSL Certificates</h2>
            <p>View and manage your SSL certificates.</p>
            <a href="{{ route('customer.ssl.index') }}" class="text-blue-500">View SSLs</a>
        </div>
    @endif
</div>
@endsection
