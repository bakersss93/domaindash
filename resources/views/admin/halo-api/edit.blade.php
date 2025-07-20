@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Halo API Details</h1>
<form method="POST" action="{{ route('halo-api.update') }}">
    @csrf
    <div class="mb-4">
        <label for="api_url" class="block text-gray-700 font-bold mb-2">API URL</label>
        <input type="text" name="api_url" id="api_url" value="{{ $settings['api_url'] }}" class="w-full border rounded px-4 py-2">
    </div>
    <div class="mb-4">
        <label for="api_key" class="block text-gray-700 font-bold mb-2">API Key</label>
        <input type="password" name="api_key" id="api_key" value="{{ $settings['api_key'] }}" class="w-full border rounded px-4 py-2">
    </div>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Changes</button>
</form>
@endsection
