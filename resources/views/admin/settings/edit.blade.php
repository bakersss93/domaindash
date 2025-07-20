@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Theme Settings</h1>
<form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-4">
        <label for="primary_color" class="block text-gray-700 font-bold mb-2">Primary Colour</label>
        <input type="color" name="primary_color" id="primary_color" value="{{ $settings->primary_color }}" class="w-32 h-10 p-0 border rounded">
    </div>
    <div class="mb-4">
        <label for="secondary_color" class="block text-gray-700 font-bold mb-2">Secondary Colour</label>
        <input type="color" name="secondary_color" id="secondary_color" value="{{ $settings->secondary_color }}" class="w-32 h-10 p-0 border rounded">
    </div>
    <div class="mb-4">
        <label for="logo" class="block text-gray-700 font-bold mb-2">Logo</label>
        <input type="file" name="logo" id="logo" class="w-full">
        @if($settings->logo_path)
            <img src="{{ asset('storage/'.$settings->logo_path) }}" alt="Logo" class="h-16 mt-2">
        @endif
    </div>
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Changes</button>
</form>
@endsection
