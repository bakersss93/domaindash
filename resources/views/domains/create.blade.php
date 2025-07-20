@extends('layouts.app')

@section('content')
<h1>Create Domain</h1>
<form action="{{ route('domains.store') }}" method="POST">
    @csrf
    <div>
        <label>Domain Name</label>
        <input type="text" name="domain_name" required>
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
        <label>Renewal Date</label>
        <input type="date" name="renewal_date">
    </div>
    <div>
        <label>Auto Renew</label>
        <input type="checkbox" name="auto_renew" value="1" checked>
    </div>
    <button type="submit">Create</button>
</form>
@endsection
