@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Manage Users</h1>
@if(auth()->user()->role === 'admin')
<a href="{{ route('users.create') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">Create New User</a>
@endif

<table class="table-auto w-full border-collapse border border-gray-300">
    <thead>
        <tr>
            <th class="border border-gray-300 px-4 py-2">Name</th>
            <th class="border border-gray-300 px-4 py-2">Email</th>
            <th class="border border-gray-300 px-4 py-2">Role</th>
            @if(auth()->user()->role === 'admin')
            <th class="border border-gray-300 px-4 py-2">Actions</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td class="border border-gray-300 px-4 py-2">{{ $user->first_name }} {{ $user->surname }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ $user->email }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ $user->role }}</td>
            @if(auth()->user()->role === 'admin')
            <td class="border border-gray-300 px-4 py-2">
                <a href="{{ route('users.edit', $user->id) }}" class="text-blue-500">Edit</a>
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
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
