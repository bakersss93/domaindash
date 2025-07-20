@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">{{ $client->business_name }}</h1>
<p><strong>ABN:</strong> {{ $client->abn }}</p>
<p><strong>Halo Reference:</strong> {{ $client->halo_reference }}</p>
<p><strong>ITGlue Org ID:</strong> {{ $client->itglue_org_id }}</p>
<p><strong>Active:</strong> {{ $client->active ? 'Yes' : 'No' }}</p>

<h2 class="text-xl font-bold mt-4 mb-2">Users</h2>
<ul class="list-disc list-inside">
@foreach($client->users as $user)
    <li>{{ $user->first_name ?? $user->name }} {{ $user->surname ?? '' }} ({{ $user->email }})</li>
@endforeach
</ul>
@endsection
