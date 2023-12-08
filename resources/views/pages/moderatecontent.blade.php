@extends('layouts.app')

@section('style')
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

<div id="buttonlist">
<button id="contentRequestsButton">View Content Unblock Requests</button>
<button id="accountRequestsButton">View Account Unblock Requests</button>
</div>

<div id="fixable" class="card-container   unblockcontent">
  <p>Blocked Content Appeals</p>
  @foreach ($unblockRequests as $unblockRequest)
  <div class="card">
      <p class="card-info">Type:{{ $unblockRequest->type}}</p>
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
    @if($unblockRequests->count() > 0)
    {{ $unblockRequests->links('pagination::bootstrap-4') }}
    @else
    <p>No More Unblock Requests Found.</p>
    @endif
  </div>
</div>

<div id="fixable" class="card-container unblockaccount" style="display:none">
  <p>Blocked Account Appeals</p>
  @foreach ($unblockAccounts as $unblockAccount)

  <div class="card">
      <p class="card-info">Unblock Request ID:{{ $unblockAccount->id}}</p>
      <p class="card-info">Name: {{ $unblockAccount->user->name}}</p>
      <p class="card-info">UserName: {{ $unblockAccount->user->username}}</p>
      <p class="card-info">Email: {{ $unblockAccount->user->email}}</p>
      <p class="card-info">Reason to Unblock: {{ $unblockAccount->appeal}}</p>
      <a href="{{ '/reviewaccount/' . $unblockAccount->id }}" class="card-link">Review Account</a>
  </div>
  @endforeach
  <div class="d-flex justify-content-center mt-4">
    @if($unblockAccounts->count() > 0)
    {{ $unblockAccounts->links('pagination::bootstrap-4') }}
    @else
    <p>No More Unblock Requests Found.</p>
    @endif
  </div>
</div>



<script>
    document.getElementById('contentRequestsButton').addEventListener('click', function() {
        document.querySelector('.unblockcontent').style.display = 'flex';
        document.querySelector('.unblockaccount').style.display = 'none';
    });

    document.getElementById('accountRequestsButton').addEventListener('click', function() {
        document.querySelector('.unblockcontent').style.display = 'none';
        document.querySelector('.unblockaccount').style.display = 'flex';
    });
</script>
@endsection