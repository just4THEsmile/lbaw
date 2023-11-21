
@extends('layouts.app')

@section('title', 'content')

@section('content')
<div class="sidebar">
  <a href="/home">Home Page</a>
  <a href="{{'/tags'}}">Tags</a>
  <a class="active" href="{{'/questions'}}">Questions</a>
  <a href="{{'/users'}}">Users</a>
</div>

<div>
<body>

    <div class="realcontent">
        <input class="searchbar" type="text" id="searchInput" placeholder="Search..." >
        <label for="sortSelect">Sort By:</label>
        <select id="sortSelect">
            <option value="date">Time</option>
            <option value="votes">Votes</option>
        </select>
        <ul id="searchResults">

        </ul>
    <div id="QuestionPagination">
    </div>
    </div>
</body>
</html>

@endsection