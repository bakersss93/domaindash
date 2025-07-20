@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Search Results</h1>

<form method="GET" action="{{ route('search.index') }}" class="mb-6 flex space-x-2">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search" class="border px-2 py-1 rounded text-black" />
    <input type="text" name="status" value="{{ request('status') }}" placeholder="Status" class="border px-2 py-1 rounded text-black" />
    <input type="text" name="service_type" value="{{ request('service_type') }}" placeholder="Service Type" class="border px-2 py-1 rounded text-black" />
    <input type="text" name="tag" value="{{ request('tag') }}" placeholder="Tag" class="border px-2 py-1 rounded text-black" />
    <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded">Search</button>
</form>

<div class="space-y-6">
    <div>
        <h2 class="text-xl font-semibold mb-2">Domains</h2>
        <ul class="list-disc pl-5">
            @forelse($domains as $domain)
                <li>{{ $domain->domain_name }}</li>
            @empty
                <li>No domains found.</li>
            @endforelse
        </ul>
    </div>

    <div>
        <h2 class="text-xl font-semibold mb-2">Hosting Services</h2>
        <ul class="list-disc pl-5">
            @forelse($hostingServices as $service)
                <li>{{ $service->service_name }}</li>
            @empty
                <li>No hosting services found.</li>
            @endforelse
        </ul>
    </div>

    <div>
        <h2 class="text-xl font-semibold mb-2">SSL Services</h2>
        <ul class="list-disc pl-5">
            @forelse($sslServices as $service)
                <li>{{ $service->certificate_name }}</li>
            @empty
                <li>No SSL services found.</li>
            @endforelse
        </ul>
    </div>

    @if(auth()->user()->role === 'admin')
    <div>
        <h2 class="text-xl font-semibold mb-2">Clients</h2>
        <ul class="list-disc pl-5">
            @forelse($clients as $client)
                <li>{{ $client->first_name }} {{ $client->surname }}</li>
            @empty
                <li>No clients found.</li>
            @endforelse
        </ul>
    </div>
    @endif
</div>
@endsection
