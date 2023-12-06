@extends('layouts.app')

@section('style')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')
<link href="{{ asset('css/moderatecontent.css') }}" rel="stylesheet">
<div class="sidebar">
  <a href="/home">Home Page</a>
  <a href="{{'/tags'}}">Tags</a>
  <a href="{{'/questions'}}">Questions</a>
  <a href="{{'/users'}}">Users</a>
  <a class="active" href="{{'/moderatecontent'}}">Blocked Content</a>

</div>

<div style="color:white; font-size:0.0001em;">Home</div>
<div id="fixable" class="card-container">
  @foreach ($unblockRequests as $unblockRequest)
  <div class="card">
      <p class="card-info">Unblock Request ID:{{ $unblockRequest->id}}</p>
      <p class="card-info">Name:{{ $unblockRequest->user->name}}</p>
      <p class="card-info">UserName:{{ $unblockRequest->user->username}}</p>
      <p class="card-info">Email:{{ $unblockRequest->user->email}}</p>
      <p class="card-info">Content ID:{{ $unblockRequest->content->id}}</p>
      <p class="card-info">Reason to Unblock:{{ $unblockRequest->description}}</p>
      <a href="{{ '/reviewcontent/' . $unblockRequest->id }}" class="card-link">Review Content</a>
  </div>
  @endforeach
  <div class="d-flex justify-content-center mt-4">
    {{ $unblockRequests->links('pagination::bootstrap-4') }}
  </div>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

@endsection