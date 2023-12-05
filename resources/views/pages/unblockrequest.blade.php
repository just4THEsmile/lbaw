@extends('layouts.app')
@section ('style')
  <link href="{{ url('css/auth.css') }}" rel="stylesheet">
  <link href="{{ url('css/unblock.css') }}" rel="stylesheet">
@endsection
@section('content')

<form method="POST" action="{{ route('sendunblock') }}">
    @csrf
    <h2>Unblock Request</h2>
    <p>Please fill in the following form to request the unblock of your content</p>
    <input type="hidden" name="content_id" value="{{ $content->id }}">
    <input type="hidden" name="user_id" value="{{ $user_id }}">
    <textarea id="content" name="content" readonly>{{ $content->content }}</textarea>
    <textarea id="reason" name="reason" placeholder="Reason" required></textarea>
    <button type="submit">
        Send Unblock Request
    </button>
</form>

@endsection