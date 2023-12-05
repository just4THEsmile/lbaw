
@extends('layouts.app')

@section('style')

<link href="{{ asset('css/tag.css') }}" rel="stylesheet">
<link href="{{ asset('css/search.css') }}" rel="stylesheet">
<link href="{{ asset('css/question_card.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

@endsection

@section('title', 'content')

@section('content')
<div class="sidebar">
  <a href="/home">Home Page</a>
  <a href="{{'/tags'}}">Tags</a>
  <a class="active" href="{{'/questions'}}">Questions</a>
  <a href="{{'/users'}}">Users</a>
  @if (Auth::check() && (Auth::user()->usertype == 'admin' || Auth::user()->usertype == 'moderator'))
    <a href="{{'/moderatecontent'}}">Blocked Content</a>
  @endif

</div>

<div>
    <div style="color:white; font-size:0.0001em;">Home</div>
    <div class="realcontent">
        <input class="searchbar" type="text" id="searchInput" placeholder="Search Question..."  >
        <label for="sortSelect">Sort By:</label>
        <select id="sortSelect">
            <option value="relevance">Relevance</option>
            <option value="date">Time</option>
            <option value="votes">Votes</option>
        </select>
        <ul id="searchResults">

        </ul>
    <div id="pagination"></div>
</div>
    <script src="{{ asset('js/questionsearch.js') }}" defer></script>
</html>

@endsection