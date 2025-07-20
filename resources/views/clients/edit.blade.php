@extends('layouts.app')

@section('content')
<h1>Edit Client</h1>
<form action="{{ route('clients.update', $client->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div>
        <label>Business Name</label>
        <input type="text" name="business_name" value="{{ $client->business_name }}" required>
    </div>
    <div>
        <label>ABN</label>
        <input type="text" name="abn" value="{{ $client->abn }}">
    </div>
    <div>
        <label>HaloPSA Reference</label>
        <input type="text" name="halopsa_reference" value="{{ $client->halopsa_reference }}">
    </div>
    <div>
        <label>ITGlue Org ID</label>
        <input type="number" name="itglue_org_id" value="{{ $client->itglue_org_id }}">
    </div>
    <div>
        <label>Active</label>
        <input type="checkbox" name="active" value="1" @checked($client->active)>
    </div>
    <button type="submit">Update</button>
</form>
@endsection
