@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Disk Usage Settings</h1>
<form method="POST" action="{{ route('disk-settings.update') }}">
    @csrf
    @method('PUT')
    <div class="mb-4">
        <label for="warning_threshold" class="block text-gray-700 font-bold mb-2">Warning Threshold (%)</label>
        <input type="number" name="warning_threshold" id="warning_threshold" value="{{ $settings->warning_threshold }}" class="w-full border rounded px-4 py-2">
    </div>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Changes</button>
</form>
@endsection
