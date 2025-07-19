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
        <label>Customer</label>
        <select name="customer_id">
            <option value="">None</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->first_name }} {{ $customer->surname }}</option>
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
