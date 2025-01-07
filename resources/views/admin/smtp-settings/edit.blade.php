@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">SMTP Settings</h1>
<form method="POST" action="{{ route('smtp-settings.update') }}">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label for="send_from_email" class="block text-gray-700 font-bold mb-2">Send From Email</label>
        <input type="email" name="send_from_email" id="send_from_email" value="{{ $settings->send_from_email }}" class="w-full border rounded px-4 py-2">
    </div>

    <div class="mb-4">
        <label for="smtp_server" class="block text-gray-700 font-bold mb-2">SMTP Server</label>
        <input type="text" name="smtp_server" id="smtp_server" value="{{ $settings->smtp_server }}" class="w-full border rounded px-4 py-2">
    </div>

    <div class="mb-4">
        <label for="smtp_port" class="block text-gray-700 font-bold mb-2">SMTP Port</label>
        <input type="number" name="smtp_port" id="smtp_port" value="{{ $settings->smtp_port }}" class="w-full border rounded px-4 py-2">
    </div>

    <div class="mb-4">
        <label for="smtp_username" class="block text-gray-700 font-bold mb-2">SMTP Username</label>
        <input type="text" name="smtp_username" id="smtp_username" value="{{ $settings->smtp_username }}" class="w-full border rounded px-4 py-2">
    </div>

    <div class="mb-4">
        <label for="smtp_password" class="block text-gray-700 font-bold mb-2">SMTP Password</label>
        <input type="password" name="smtp_password" id="smtp_password" value="{{ $settings->smtp_password }}" class="w-full border rounded px-4 py-2">
    </div>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Changes</button>
</form>
@endsection
