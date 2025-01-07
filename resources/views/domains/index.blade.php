@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Domains</h1>
<a href="{{ route('domains.create') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">Add New Domain</a>

<table class="table-auto w-full border-collapse border border-gray-300">
    <thead>
        <tr>
            <th class="border border-gray-300 px-4 py-2">Domain Name</th>
            <th class="border border-gray-300 px-4 py-2">Customer</th>
            <th class="border border-gray-300 px-4 py-2">Renewal Date</th>
            <th class="border border-gray-300 px-4 py-2">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($domains as $domain)
        <tr>
            <td class="border border-gray-300 px-4 py-2">{{ $domain->domain_name }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ $domain->customer->first_name }} {{ $domain->customer->surname }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ $domain->renewal_date }}</td>
            <td class="border border-gray-300 px-4 py-2">
                <a href="{{ route('domains.edit', $domain->id) }}" class="text-blue-500">Edit</a>
                <form action="{{ route('domains.destroy', $domain->id) }}" method="POST" style="display:inline;">
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
