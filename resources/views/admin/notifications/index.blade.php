@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Notifications</h1>

<table class="table-auto w-full border-collapse border border-gray-300">
    <thead>
        <tr>
            <th class="border border-gray-300 px-4 py-2">Type</th>
            <th class="border border-gray-300 px-4 py-2">Details</th>
            <th class="border border-gray-300 px-4 py-2">Is Read</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($notifications as $notification)
        <tr>
            <td class="border border-gray-300 px-4 py-2">{{ ucfirst($notification->notification_type) }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ json_encode($notification->details) }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ $notification->is_read ? 'Yes' : 'No' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
