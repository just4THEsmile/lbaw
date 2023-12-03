@extends('layouts.app')


@section('content')
<div class="sidebar">
  <a href="/home">Home Page</a>
  <a href="{{'/tags'}}">Tags</a>
  <a href="{{'/questions'}}">Questions</a>
  <a href="{{'/users'}}">Users</a>
  <a class="active" href="{{'/moderatecontent'}}">Blocked Content</a>

</div>

<div style="color:white; font-size:0.0001em;">Home</div>
<div id='fixable'>
  @foreach ($unblockRequests as $unblockRequest)
  <code>{{ $unblockRequest}}</code>
  <a href="{{ '/reviewcontent/' . $unblockRequest->id }}">Review Content</a>

  @endforeach
  {{ $unblockRequests->links('vendor.pagination.custom') }}

</div>


@endsection