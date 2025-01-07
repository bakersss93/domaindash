
@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Edit Email Template</h1>

<form method="POST" action="{{ route('email-templates.update', $template->id) }}">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label for="template_type" class="block text-gray-700 font-bold mb-2">Template Type</label>
        <input type="text" name="template_type" id="template_type" value="{{ $template->template_type }}" disabled class="w-full border rounded px-4 py-2 bg-gray-100">
    </div>

    <div class="mb-4">
        <label for="subject" class="block text-gray-700 font-bold mb-2">Subject</label>
        <input type="text" name="subject" id="subject" value="{{ $template->subject }}" class="w-full border rounded px-4 py-2">
    </div>

    <div class="mb-4">
        <label for="body" class="block text-gray-700 font-bold mb-2">Body</label>
        <textarea name="body" id="body" rows="10" class="w-full border rounded px-4 py-2">{{ $template->body }}</textarea>
    </div>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Changes</button>
</form>
@endsection
