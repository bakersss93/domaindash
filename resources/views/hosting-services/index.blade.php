@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Hosting Services</h1>
<a href="{{ route('hosting-services.create') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">Add New Hosting</a>

<table class="table-auto w-full border-collapse border border-gray-300">
    <thead>
        <tr>
            <th class="border border-gray-300 px-4 py-2">Service Name</th>
            <th class="border border-gray-300 px-4 py-2">Customer</th>
            <th class="border border-gray-300 px-4 py-2">Disk Usage</th>
            <th class="border border-gray-300 px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($hostingServices as $service)
        <tr>
            <td class="border border-gray-300 px-4 py-2">{{ $service->service_name }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ $service->customer->first_name }} {{ $service->customer->surname }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ $service->disk_usage }} MB</td>
            <td class="border border-gray-300 px-4 py-2">
                <a href="{{ route('hosting-services.edit', $service->id) }}" class="text-blue-500">Edit</a>
                <form action="{{ route('hosting-services.destroy', $service->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500">Delete</button>
                </form>
                @php
                    $cpanelRoute = auth()->user()->role === 'admin'
                        ? route('hosting-services.cpanel', $service->id)
                        : route('customer.hosting.cpanel', $service->id);
                @endphp
                <a href="{{ $cpanelRoute }}" class="text-green-500 ml-2">cPanel Login</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
