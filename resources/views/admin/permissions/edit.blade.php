@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Role Permissions</h1>
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif
<form method="POST" action="{{ route('permissions.update') }}">
    @csrf
    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2">Role</th>
                @foreach($permissions as $permission)
                    <th class="border border-gray-300 px-4 py-2">{{ $permission }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
            <tr>
                <td class="border border-gray-300 px-4 py-2">{{ ucfirst($role) }}</td>
                @foreach($permissions as $permission)
                <td class="border border-gray-300 px-4 py-2 text-center">
                    <input type="checkbox" name="permissions[{{ $role }}][]" value="{{ $permission }}"
                        @checked(isset($rolePermissions[$role]) && $rolePermissions[$role]->pluck('permission')->contains($permission)) />
                </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Save</button>
</form>
@endsection
