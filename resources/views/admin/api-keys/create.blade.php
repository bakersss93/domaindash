@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Create API Key</h1>
<form method="POST" action="{{ route('api-keys.store') }}" class="space-y-4">
    @csrf
    <div>
        <label class="block">Name</label>
        <input type="text" name="key_name" class="border rounded w-full" required>
    </div>
    <div>
        <label class="block">Description</label>
        <textarea name="description" class="border rounded w-full"></textarea>
    </div>
    <div>
        <label class="block">Permissions</label>
        <select name="permissions" class="border rounded w-full">
            <option value="read-only">Read Only</option>
            <option value="read-write">Read/Write</option>
        </select>
    </div>
    <div>
        <label class="block">Allowed IPs (comma separated)</label>
        <input type="text" name="allowed_ips" class="border rounded w-full">
    </div>
    <div>
        <label class="block">Rate Limit (per minute)</label>
        <input type="number" name="rate_limit" class="border rounded w-full" value="60">
    </div>
    <div>
        <label class="block">Expires At</label>
        <input type="datetime-local" name="expires_at" class="border rounded w-full">
    </div>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create</button>
</form>
@endsection
