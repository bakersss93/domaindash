@extends('layouts.app')

@section('content')
<h1>Edit Hosting Service</h1>
<form action="{{ route('hosting-services.update', $hostingService->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div>
        <label>Service Name</label>
        <input type="text" name="service_name" value="{{ $hostingService->service_name }}" required>
    </div>
    <div>
        <label>Customer</label>
        <select name="customer_id">
            <option value="">None</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}" @selected($hostingService->customer_id == $customer->id)>{{ $customer->first_name }} {{ $customer->surname }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label>Disk Usage (MB)</label>
        <input type="number" name="disk_usage" value="{{ $hostingService->disk_usage }}">
    </div>
    <div>
        <label>Database Usage (MB)</label>
        <input type="number" name="database_usage" value="{{ $hostingService->database_usage }}">
    </div>
    <div>
        <label>Disk Space Threshold (%)</label>
        <input type="number" name="disk_space_threshold" value="{{ $hostingService->disk_space_threshold }}">
    </div>
    <div>
        <label>Hosting Plan</label>
        <input type="text" name="hosting_plan" value="{{ $hostingService->hosting_plan }}" required>
    </div>
    <button type="submit">Update</button>
</form>
@endsection
