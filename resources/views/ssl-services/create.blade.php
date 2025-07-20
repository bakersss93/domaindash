@extends('layouts.app')

@section('content')
<h1>Create SSL Service</h1>
<form action="{{ route('ssl-services.store') }}" method="POST">
    @csrf
    <div>
        <label>Certificate Name</label>
        <input type="text" name="certificate_name" required>
    </div>
    <div>
        <label>Client</label>
        <select name="client_id">
            <option value="">None</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}">{{ $client->business_name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label>Expiration Date</label>
        <input type="date" name="expiration_date" required>
    </div>
    <div>
        <label>Details</label>
        <textarea name="details"></textarea>
    </div>
    <button type="submit">Create</button>
</form>
@endsection
