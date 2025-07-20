@extends('layouts.app')

@section('content')
<h1>Edit SSL Service</h1>
<form action="{{ route('ssl-services.update', $sslService->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div>
        <label>Certificate Name</label>
        <input type="text" name="certificate_name" value="{{ $sslService->certificate_name }}" required>
    </div>
    <div>
        <label>Client</label>
        <select name="client_id">
            <option value="">None</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}" @selected($sslService->client_id == $client->id)>{{ $client->business_name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label>Expiration Date</label>
        <input type="date" name="expiration_date" value="{{ optional($sslService->expiration_date)->format('Y-m-d') }}" required>
    </div>
    <div>
        <label>Details</label>
        <textarea name="details">{{ $sslService->details }}</textarea>
    </div>
    <button type="submit">Update</button>
</form>
@endsection
