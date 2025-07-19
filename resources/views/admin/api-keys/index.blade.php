@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">API Keys</h1>
@if(auth()->user()->role === 'admin')
<a href="{{ route('api-keys.create') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">Create API Key</a>
@endif

<table class="table-auto w-full border-collapse border border-gray-300">
    <thead>
        <tr>
            <th class="border border-gray-300 px-4 py-2">Name</th>
            <th class="border border-gray-300 px-4 py-2">Permissions</th>
            <th class="border border-gray-300 px-4 py-2">Allowed IPs</th>
            @if(auth()->user()->role === 'admin')
            <th class="border border-gray-300 px-4 py-2">Actions</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($apiKeys as $key)
        <tr>
            <td class="border border-gray-300 px-4 py-2">{{ $key->key_name }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ $key->permissions }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ $key->allowed_ips }}</td>
            @if(auth()->user()->role === 'admin')
            <td class="border border-gray-300 px-4 py-2">
                <form action="{{ route('api-keys.destroy', $key->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500">Delete</button>
                </form>
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
