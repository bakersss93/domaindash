@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Manage Email Templates</h1>
@if(auth()->user()->role === 'admin')
<a href="{{ route('email-templates.create') }}" class="bg-green-500 text-white px-4 py-2 rounded mb-4 inline-block">Add New Template</a>
@endif

<table class="table-auto w-full border-collapse border border-gray-300">
    <thead>
        <tr>
            <th class="border border-gray-300 px-4 py-2">Template Type</th>
            <th class="border border-gray-300 px-4 py-2">Subject</th>
            @if(auth()->user()->role === 'admin')
            <th class="border border-gray-300 px-4 py-2">Actions</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($templates as $template)
        <tr>
            <td class="border border-gray-300 px-4 py-2">{{ ucfirst($template->template_type) }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ $template->subject }}</td>
            @if(auth()->user()->role === 'admin')
            <td class="border border-gray-300 px-4 py-2">
                <a href="{{ route('email-templates.edit', $template->id) }}" class="text-blue-500">Edit</a>
                <form action="{{ route('email-templates.destroy', $template->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500">Delete</button>
                </form>
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
