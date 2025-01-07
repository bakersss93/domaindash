@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white shadow rounded p-6">
    <h1 class="text-2xl font-bold mb-4 text-center">Login</h1>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full border rounded px-4 py-2">
        </div>

        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-bold mb-2">Password</label>
            <input id="password" type="password" name="password" required class="w-full border rounded px-4 py-2">
        </div>

        <div class="mb-4 flex items-center">
            <input type="checkbox" name="remember" id="remember" class="mr-2">
            <label for="remember" class="text-gray-700">Remember Me</label>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded w-full">Login</button>
    </form>
</div>
@endsection
