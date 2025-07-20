@extends('layouts.app')

@section('content')
<h1>Create Client</h1>
<form action="{{ route('clients.store') }}" method="POST">
    @csrf
    <div>
        <label>Business Name</label>
        <input type="text" name="business_name" required>
    </div>
    <div>
        <label>ABN</label>
        <input type="text" name="abn">
    </div>
    <div>
        <label>HaloPSA Reference</label>
        <input type="text" name="halopsa_reference">
    </div>
    <div>
        <label>ITGlue Org ID</label>
        <input type="number" name="itglue_org_id">
    </div>
    <div>
        <label>Active</label>
        <input type="checkbox" name="active" value="1" checked>
    </div>
    <button type="submit">Create</button>
</form>
@endsection
