@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">My Domains</h1>

    <form action="{{ route('customer.domains.search') }}" method="GET" class="flex mb-4">
        <input type="text" name="query" placeholder="Search domains" class="border rounded-l px-4 py-2" />
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r">Search</button>
    </form>

    <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2">Domain</th>
                <th class="border border-gray-300 px-4 py-2">Renewal Date</th>
                <th class="border border-gray-300 px-4 py-2">Auto Renew</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($domains as $domain)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $domain->domain_name }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $domain->renewal_date }}</td>
                    <td class="border border-gray-300 px-4 py-2">
                        {{ $domain->auto_renew ? 'Enabled' : 'Disabled' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center border border-gray-300 px-4 py-2">
                        No domains found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
