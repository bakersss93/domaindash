@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Backup Settings</h1>
<form method="POST" action="{{ route('backup-settings.update') }}">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label for="sftp_server" class="block text-gray-700 font-bold mb-2">SFTP Server</label>
        <input type="text" name="sftp_server" id="sftp_server" value="{{ $settings->sftp_server }}" class="w-full border rounded px-4 py-2">
    </div>

    <div class="mb-4">
        <label for="sftp_port" class="block text-gray-700 font-bold mb-2">SFTP Port</label>
        <input type="number" name="sftp_port" id="sftp_port" value="{{ $settings->sftp_port }}" class="w-full border rounded px-4 py-2">
    </div>

    <div class="mb-4">
        <label for="sftp_username" class="block text-gray-700 font-bold mb-2">SFTP Username</label>
        <input type="text" name="sftp_username" id="sftp_username" value="{{ $settings->sftp_username }}" class="w-full border rounded px-4 py-2">
    </div>

    <div class="mb-4">
        <label for="sftp_password" class="block text-gray-700 font-bold mb-2">SFTP Password</label>
        <input type="password" name="sftp_password" id="sftp_password" value="{{ $settings->sftp_password }}" class="w-full border rounded px-4 py-2">
    </div>

    <div class="mb-4">
        <label for="backup_retention" class="block text-gray-700 font-bold mb-2">Backup Retention (Days)</label>
        <input type="number" name="backup_retention" id="backup_retention" value="{{ $settings->backup_retention }}" class="w-full border rounded px-4 py-2">
    </div>

    <div class="mb-4">
        <label for="backup_time" class="block text-gray-700 font-bold mb-2">Backup Time</label>
        <input type="time" name="backup_time" id="backup_time" value="{{ $settings->backup_time }}" class="w-full border rounded px-4 py-2">
    </div>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Changes</button>
</form>
@endsection
