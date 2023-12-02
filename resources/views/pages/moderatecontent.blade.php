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
      <a href="{{ '/reviewcontent/' . $unblockRequest->id }}">Review Content</a>

  @endforeach
</div>

{{ $unblockRequests->links() }}
@endsection