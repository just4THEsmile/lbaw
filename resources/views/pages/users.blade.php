@extends('layouts.app')

@section('title', 'content')

@section('content')
<div class="sidebar">
  <a href="/home">Home Page</a>
  <a href="{{'/tags'}}">Tags</a>
  <a href="{{'/questions'}}">Questions</a>
  <a class="active" href="{{'/users'}}">Users</a>
</div>
<div class="userpage">
    <h1>Users</h1>
    <div class="users">
        @php
            $users = App\Models\User::all();
        @endphp
        @foreach ($users as $user)
        <div class="user">
            <a href="{{ '/profile/' . $user->id }}">
            <img src="{{ asset('storage/' . $user->profilepicture) }}" alt="Profile Picture">
            <h2>{{ $user->name }}</h2>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
