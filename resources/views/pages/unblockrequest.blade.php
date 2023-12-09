@extends('layouts.app')
@section ('style')
  <link href="{{ url('css/unblock.css') }}" rel="stylesheet">
@endsection
@section('content')

<div class="sidebar">
    <a href="/home">Home Page</a>
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
        <div class="card-header">Unblock Request</div>
        <div class="card-body">
          <form method="POST" action="{{ route('sendunblock') }}">
            @csrf
            <p>Please fill in the following form to request the unblock of your content</p>
            <input type="hidden" name="content_id" value="{{ $content->id }}">
            <input type="hidden" name="user_id" value="{{ $user_id }}">
            <div class="form-group">
               <div>Title</label>
               <div id="blockedtitle" class="form-control"  style="white-space: pre-wrap;">{{ $content->question->title }}</div>
            </div>
            <div class="form-group">
               <div>Content</label>
               <div id="blockedcontent" class="form-control" style="white-space: pre-wrap;">{{ $content->content }}</div>
            </div>
            <div class="form-group">
              <label for="reason">Reason</label>
              <textarea id="reason" name="reason" class="form-control" placeholder="Reason" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">
              Send Unblock Request
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  window.onload = function() {
    let textarea = document.getElementById('content');
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 'em';
  }
</script>
@endsection