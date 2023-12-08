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
  @if (Auth::check() && (Auth::user()->usertype === 'admin' || Auth::user()->usertype === 'moderator'))
    <a href="{{'/moderatecontent'}}">Blocked Content</a>
  @endif

</div>
<div class="userpage">
    <div id='search'>
        <div style="color:white; font-size:0.0001em;">Home</div>
        <input class="searchbar" type="text" id="searchUserInput" placeholder="Search...">
        <span class="error" id ="error"></span>
        <label for="sortSelect">Search By:</label>
        <select id="sortSelect">
            <option value="relevance">Relevance</option>
            <option value="username">Username</option>
            <option value="name">Name</option>
        </select>
    </div>
    <div class="users">
    </div>
    <div id="pagination"></div>
    <script src="{{ asset('js/usersearch.js') }}" defer></script>
</div>
@endsection
