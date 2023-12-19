@extends('layouts.app')
@section ('style')
  <link href="{{ url('css/auth.css') }}" rel="stylesheet">
@endsection
@section('pagename')
review content
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
          <form method="POST" action="{{ route('processRequest') }}">
            @csrf
            <input type="hidden" name="unblock_request_id" value="{{ $unblockRequest->id }}">
            <input type="hidden" name="content_id" value="{{ $content->id }}">
            <div class="form-group">
              <label>Content</label>
              <div class="form-control" readonly style="white-space: pre-wrap;">{{$content}}</div>
            </div>
            <div class="form-group">
              <label>Question Title</label>
              <div class="form-control" readonly style="white-space: pre-wrap;">{{$content->question->title}}</div>
            </div>
            <div class="form-group">
              <label>Content</label>
              <div class="form-control" readonly style="white-space: pre-wrap;">{{$content->content}}</div>
            </div>
            <div class="form-group">
              <label>Unblock Request Description</label>
              <div class="form-control" readonly style="white-space: pre-wrap;">{{$unblockRequest->description}}</div>
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