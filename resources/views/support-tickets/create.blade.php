@extends('layouts.app')

@section('content')
<h1>Log Support Ticket</h1>
<form action="{{ route('support-ticket.store') }}" method="POST">
    @csrf
    <div>
        <label>Subject</label>
        <input type="text" name="subject" required>
    </div>
    <div>
        <label>Message</label>
        <textarea name="message" required></textarea>
    </div>
    <button type="submit">Submit</button>
</form>
@endsection
