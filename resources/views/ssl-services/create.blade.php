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
        <label>Customer</label>
        <select name="customer_id">
            <option value="">None</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->surname }}</option>
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
