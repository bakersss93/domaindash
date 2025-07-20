@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">SSL Services</h1>
<a href="{{ route('ssl-services.create') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">Add New SSL</a>
<table class="table-auto w-full border-collapse border border-gray-300">
    <thead>
        <tr>
            <th class="border border-gray-300 px-4 py-2">Certificate Name</th>
            <th class="border border-gray-300 px-4 py-2">Client</th>
            <th class="border border-gray-300 px-4 py-2">Expiration Date</th>
            <th class="border border-gray-300 px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sslServices as $ssl)
        <tr>
            <td class="border border-gray-300 px-4 py-2">{{ $ssl->certificate_name }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ optional($ssl->client)->business_name }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ $ssl->expiration_date }}</td>
            <td class="border border-gray-300 px-4 py-2">
                <a href="{{ route('ssl-services.edit', $ssl->id) }}" class="text-blue-500">Edit</a>
                <form action="{{ route('ssl-services.destroy', $ssl->id) }}" method="POST" style="display:inline;">
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
