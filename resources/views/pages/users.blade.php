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
    <div id='search'>
        <div style="color:white; font-size:0.0001em;">Home</div>
        <input class="searchbar" type="text" id="searchUserInput" placeholder="Search...">
        <label for="sortSelect">Sort By:</label>
        <select id="sortSelect">
            <option value="username">Username</option>
            <option value="name">Name</option>
            <option value="points">Points</option>
        </select>
    </div>
    <div class="users">
        @foreach ($users as $user)
        <div class="user">
            <a href="{{ '/profile/' . $user->id }}">
            <img src="{{ asset('storage/' . $user->profilepicture) }}" alt="Profile Picture">
            <h2>Name: {{ $user->name }}</h2>
            <h2>Username: {{ $user->username}}</h2>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
