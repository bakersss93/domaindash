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
        <label>Customer</label>
        <select name="customer_id">
            <option value="">None</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}" @selected($domain->customer_id == $customer->id)>{{ $customer->first_name }} {{ $customer->surname }}</option>
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
    <div>
        <label>DNS Records (JSON)</label>
        <textarea name="dns_records" rows="5" class="w-full">{{ json_encode($domain->dns_records, JSON_PRETTY_PRINT) }}</textarea>
    </div>
    <button type="submit">Update</button>
</form>
@endsection
