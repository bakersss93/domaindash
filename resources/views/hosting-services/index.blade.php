@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Hosting Services</h1>
<a href="{{ route('hosting-services.create') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">Add New Hosting</a>

<table class="table-auto w-full border-collapse border border-gray-300">
    <thead>
        <tr>
            <th class="border border-gray-300 px-4 py-2">Service Name</th>
            <th class="border border-gray-300 px-4 py-2">Client</th>
            <th class="border border-gray-300 px-4 py-2">Disk Usage</th>
            <th class="border border-gray-300 px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($hostingServices as $service)
        <tr>
            <td class="border border-gray-300 px-4 py-2">{{ $service->service_name }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ optional($service->client)->business_name }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ $service->disk_usage }} MB</td>
            <td class="border border-gray-300 px-4 py-2">
                <a href="{{ route('hosting-services.edit', $service->id) }}" class="text-blue-500">Edit</a>
                <form action="{{ route('hosting-services.destroy', $service->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
