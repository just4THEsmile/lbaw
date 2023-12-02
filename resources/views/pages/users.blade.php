@extends('layouts.app')

@section('style')

  <link href="{{ asset('css/users.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
@endsection

@section('title', 'content')

@section('content')
<div class="sidebar">
  <a href="/home">Home Page</a>
  <a href="{{'/tags'}}">Tags</a>
  <a href="{{'/questions'}}">Questions</a>
  <a class="active" href="{{'/users'}}">Users</a>
  <a href="{{'/moderatecontent'}}">Blocked Content</a>

</div>
<div class="userpage">
    <div id='search'>
        <div style="color:white; font-size:0.0001em;">Home</div>
        <input class="searchbar" type="text" id="searchUserInput" placeholder="Search...">
        <label for="sortSelect">Search By:</label>
        <select id="sortSelect">
            <option value="username">Username</option>
            <option value="name">Name</option>
        </select>
    </div>
    <div class="users">
        @foreach ($users as $user)
        <div class="user">
            <a href="{{ '/profile/' . $user->id }}">
            <img src="{{ $user->getProfileImage() }}" alt="Profile Picture">
            <p>Name:</p>
            <h2>{{ $user->name }}</h2>
            <p>Username:</p>
            <h2>{{ $user->username}}</h2>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
