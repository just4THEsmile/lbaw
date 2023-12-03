@extends('layouts.app')
@section ('style')
  <link href="{{ url('css/auth.css') }}" rel="stylesheet">
@endsection
@section('content')

<form method="POST" action="{{ route('processRequest') }}">
    @csrf
    <input type="hidden" name="unblock_request_id" value="{{ $unblockRequest->id }}">
    <input type="hidden" name="content_id" value="{{ $content->id }}">
    <button type="submit" name="action" value="unblock">Accept and Unblock</button>
    <button type="submit" name="action" value="keep_blocked">Reject and Keep Blocked</button>
</form>

@endsection