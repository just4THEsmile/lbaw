
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
        <ul id="searchResults">
        @foreach ($questions as $question)


        <div class= "answercard">
            <a class="title" href="{{ url('/question/'.$question->id) }}">{{ $question->title }}</a>
            <div class ="content">
                <p class="votes">{{ $question->votes }}</p>
                <p >{{ $question->content }}</p>
                <a class= "username" href="{{ url('/profile/'.$question->userid) }}">{{ $question->username }}</a>
                <p class="date">{{ $question->date }}</p>
            </div>
        </div>
@endforeach
        </ul>
    <div class="pagination">
    </div>
    </div>
</body>
</html>

@endsection