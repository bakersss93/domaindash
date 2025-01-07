@extends('layouts.app')

@section('content')
<h1>Create User</h1>
<form action="{{ route('users.store') }}" method="POST">
    @csrf
    <div>
        <label>First Name</label>
        <input type="text" name="first_name" required>
    </div>
    <div>
        <label>Surname</label>
        <input type="text" name="surname" required>
    </div>
    <div>
        <label>Email</label>
        <input type="email" name="email" required>
    </div>
    <div>
        <label>Password</label>
        <input type="password" name="password" required>
    </div>
    <div>
        <label>Role</label>
        <select name="role" required>
            <option value="admin">Admin</option>
            <option value="customer">Customer</option>
        </select>
    </div>
    <button type="submit">Create</button>
</form>
@endsection
