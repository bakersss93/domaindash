@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Manage Users</h1>
@if(auth()->user()->role === 'admin')
<a href="{{ route('users.create') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">Create New User</a>
@endif

<form method="GET" class="mb-4 flex space-x-2">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search" class="border px-2" />
    <select name="role" class="border px-2">
        <option value="">All Roles</option>
        <option value="admin" @selected(request('role')==='admin')>Admin</option>
        <option value="customer" @selected(request('role')==='customer')>Customer</option>
    </select>
    <button type="submit" class="px-4 py-2 bg-blue-500 text-white">Filter</button>
</form>

<table class="table-auto w-full border-collapse border border-gray-300">
    <thead>
        <tr>
            <th class="border border-gray-300 px-4 py-2">First Name</th>
            <th class="border border-gray-300 px-4 py-2">Surname</th>
            <th class="border border-gray-300 px-4 py-2">Email</th>
            <th class="border border-gray-300 px-4 py-2">Role</th>
            <th class="border border-gray-300 px-4 py-2">Clients</th>
            @if(auth()->user()->role === 'admin')
            <th class="border border-gray-300 px-4 py-2">Actions</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td class="border border-gray-300 px-4 py-2">{{ $user->first_name }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ $user->surname }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ $user->email }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ $user->role }}</td>
            <td class="border border-gray-300 px-4 py-2">
                {{ $user->clients->pluck('first_name')->implode(', ') }}
            </td>
            @if(auth()->user()->role === 'admin')
            <td class="border border-gray-300 px-4 py-2">
                <a href="{{ route('users.edit', $user->id) }}" class="text-blue-500">Edit</a>
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500">Delete</button>
                </form>
                <form action="{{ route('users.impersonate', $user->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="text-green-500 ml-2">Impersonate</button>
                </form>
                <form action="{{ route('users.reset_password', $user->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="text-yellow-500 ml-2">Reset Password</button>
                </form>
                <form action="{{ route('users.reset_mfa', $user->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="text-purple-500 ml-2">Reset MFA</button>
                </form>
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
