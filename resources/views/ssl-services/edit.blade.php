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
        <label>Customer</label>
        <select name="customer_id">
            <option value="">None</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}" @selected($sslService->customer_id == $customer->id)>{{ $customer->first_name }} {{ $customer->surname }}</option>
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
