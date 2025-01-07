@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Synergy API Details</h1>
<form method="POST" action="{{ route('synergy-api.update') }}">
    @csrf

    <div class="mb-4">
        <label for="reseller_id" class="block text-gray-700 font-bold mb-2">Reseller ID</label>
        <input type="text" name="reseller_id" id="reseller_id" value="{{ $settings['reseller_id'] }}" class="w-full border rounded px-4 py-2">
    </div>

    <div class="mb-4">
        <label for="api_key" class="block text-gray-700 font-bold mb-2">API Key</label>
        <input type="password" name="api_key" id="api_key" value="{{ $settings['api_key'] }}" class="w-full border rounded px-4 py-2">
    </div>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Changes</button>
</form>
@endsection
