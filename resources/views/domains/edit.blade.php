@extends('layouts.app')

@section('content')
<h1>Edit Domain</h1>
<form action="{{ route('domains.update', $domain->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div>
        <label>Domain Name</label>
        <input type="text" name="domain_name" value="{{ $domain->domain_name }}" required>
    </div>
    <div>
        <label>Client</label>
        <select name="client_id">
            <option value="">None</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}" @selected($domain->client_id == $client->id)>{{ $client->business_name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label>Renewal Date</label>
        <input type="date" name="renewal_date" value="{{ optional($domain->renewal_date)->format('Y-m-d') }}">
    </div>
    <div>
        <label>Auto Renew</label>
        <input type="checkbox" name="auto_renew" value="1" @checked($domain->auto_renew)>
    </div>
    <button type="submit">Update</button>
</form>
@endsection
