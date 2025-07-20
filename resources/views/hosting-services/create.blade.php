@extends('layouts.app')

@section('content')
<h1>Create Hosting Service</h1>
<form action="{{ route('hosting-services.store') }}" method="POST">
    @csrf
    <div>
        <label>Service Name</label>
        <input type="text" name="service_name" required>
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
        <label>Disk Usage (MB)</label>
        <input type="number" name="disk_usage" value="0">
    </div>
    <div>
        <label>Database Usage (MB)</label>
        <input type="number" name="database_usage" value="0">
    </div>
    <div>
        <label>Disk Space Threshold (%)</label>
        <input type="number" name="disk_space_threshold" value="80">
    </div>
    <div>
        <label>Hosting Plan</label>
        <input type="text" name="hosting_plan" required>
    </div>
    <button type="submit">Create</button>
</form>
@endsection
