@extends('layouts.app')
@section ('style')
  <link href="{{ url('css/auth.css') }}" rel="stylesheet">
@endsection
@section('pagename')
Review {{ $unblockaccount->username }}'s Account
@endsection

@section('og')
  <meta property="og:title" content="Review {{ $unblockaccount->username }}'s Account" />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="{{ url('/reviewaccount/'.$unblockaccount->id) }}" />
  <meta property="og:description" content="Review {{ $unblockaccount->username }}'s Account" />
  <meta property="og:image" content="{{ url('/images/logo.png') }}" />
@endsection

@section('content')
<div class="sidebar">
    <a href="/home">Home Page</a>
    <a href="/feed">Feed</a>
    <a href="{{'/tags'}}">Tags</a>
    <a href="{{'/questions'}}">Questions</a>
    <a href="{{'/users'}}">Users</a>
    @if (Auth::check() && (Auth::user()->usertype == 'admin' || Auth::user()->usertype == 'moderator'))
        <a href="{{'/moderatecontent'}}">Blocked Content</a>
    @endif
</div>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Review Content</div>
        <div class="card-body">
          <form method="POST" action="{{ route('processAccount') }}">
            @csrf
            <input type="hidden" name="unblock_request_id" value="{{ $unblockaccount->id }}">
            <div class="form-group">
              <label>Unblock Account Appeal</label>
              <div class="form-control" readonly style="white-space: pre-wrap;">{{$unblockaccount->appeal}}</div>
            </div>
            <button type="submit" name="action" value="unblock" class="btn btn-success">Accept and Unblock</button>
            <button type="submit" name="action" value="keep_blocked" class="btn btn-danger">Reject and Keep Blocked</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection