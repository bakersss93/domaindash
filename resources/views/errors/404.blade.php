@extends('layouts.app')

@section('content')
<div class="text-center mt-16">
    <h1 class="text-6xl font-bold text-red-500">404</h1>
    <p class="text-xl text-gray-700 mt-4">The page you are looking for could not be found.</p>
    <a href="{{ route('home') }}" class="mt-6 inline-block bg-blue-500 text-white px-4 py-2 rounded">Return to Home</a>
</div>
@endsection
