@extends('layouts.app')

@section('content')
<h1>Edit User</h1>
<form action="{{ route('users.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div>
        <label>First Name</label>
        <input type="text" name="first_name" value="{{ $user->first_name }}" required>
    </div>
    <div>
        <label>Surname</label>
        <input type="text" name="surname" value="{{ $user->surname }}" required>
    </div>
    <div>
        <label>Email</label>
        <input type="email" name="email" value="{{ $user->email }}" required>
    </div>
    <div>
        <label>Password (leave blank to keep current)</label>
        <input type="password" name="password">
    </div>
    <div>
        <label>Role</label>
        <select name="role" required>
            <option value="Administrator" @selected($user->getRoleNames()->first() === 'Administrator')>Administrator</option>
            <option value="Technician" @selected($user->getRoleNames()->first() === 'Technician')>Technician</option>
            <option value="Customer" @selected($user->getRoleNames()->first() === 'Customer')>Customer</option>
        </select>
    </div>
    <button type="submit">Update</button>
</form>
@endsection
