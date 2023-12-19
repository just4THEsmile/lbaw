@extends('layouts.app')

@section('style')
@endsection

@section('pagename')
Moderate Users
@endsection 

@section('content')
<link href="{{ asset('css/moderatecontent.css') }}" rel="stylesheet">
<div class="sidebar">
  <a href="/home">Home Page</a>
  <a href="/feed">Feed</a>
  <a href="{{'/tags'}}">Tags</a>
  <a href="{{'/questions'}}">Questions</a>
  <a href="{{'/users'}}">Users</a>
  <a class="active" href="{{'/moderatecontent'}}">Blocked Content</a>

</div>

<div style="color:white; font-size:0.0001em;">Home</div>

<div id="buttonlist">
<form action="{{ route('moderatecontent')}}" method='get' >
    <button  type='submit' class='edit' name="edit-button">View Content Unblock Requests</button>
</form>
<form action="{{ route('moderateusers') }}" method='get' >
    <button class="active" type='submit' class='edit' name="edit-button">View Account Unblock Requests</button>
</form>
</div>

<div id="fixable" class="card-container unblockaccount">
  <p>Blocked Account Appeals</p>
  @if($errors->has('unblockaccount'))
      <span class="error">
          {{ $errors->first('unblockaccount') }}
      </span>
  @endif
  @if($errors->has('user'))
      <span class="error">
          {{ $errors->first('user') }}
      </span>
  @endif
  <?php echo json_decode($unblockAccounts) ?>
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

@endsection