@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Backups</h1>
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif
<form method="POST" action="{{ route('backups.store') }}" class="mb-4">
    @csrf
    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Run Backup</button>
</form>
<table class="table-auto w-full border-collapse border border-gray-300">
    <thead>
        <tr>
            <th class="border border-gray-300 px-4 py-2">File</th>
            <th class="border border-gray-300 px-4 py-2">Created</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($backups as $backup)
        <tr>
            <td class="border border-gray-300 px-4 py-2">{{ $backup->file_name }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ $backup->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
