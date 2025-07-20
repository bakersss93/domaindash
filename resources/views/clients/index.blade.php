@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Clients</h1>
<a href="{{ route('clients.create') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">Add New Client</a>

<table class="table-auto w-full border-collapse border border-gray-300">
    <thead>
        <tr>
            <th class="border border-gray-300 px-4 py-2">Business Name</th>
            <th class="border border-gray-300 px-4 py-2">Active</th>
            <th class="border border-gray-300 px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($clients as $client)
        <tr>
            <td class="border border-gray-300 px-4 py-2">{{ $client->business_name }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ $client->active ? 'Yes' : 'No' }}</td>
            <td class="border border-gray-300 px-4 py-2">
                <a href="{{ route('clients.show', $client->id) }}" class="text-blue-500 mr-2">View</a>
                <a href="{{ route('clients.edit', $client->id) }}" class="text-blue-500 mr-2">Edit</a>
                <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display:inline;">
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
