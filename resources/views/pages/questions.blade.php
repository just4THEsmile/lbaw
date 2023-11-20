
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

<div style="color:white;">Home</div>
    <div class="questionslist">
    <div style="color:white;">Home</div>
        <input class="searchbar" type="text" id="searchInput" placeholder="Search A Question..." >
        <ul id="searchResults">
        @foreach ($questions as $question)
        <div class= "answercard">
            <a class="title" href="{{ url('/question/'.$question->id) }}">{{ $question->title }}</a>
            <div class ="content">
                <p class="votes">{{ $question->votes }}</p>
                <p >{{ $question->content }}</p>
                <a class= "username" href="{{ url('/user/'.$question->userid) }}">{{ $question->username }}</a>
                <p class="date">{{ $question->date }}</p>
            </div>
        </div>
        @endforeach
        </ul>
    <div class="pagination">
    </div>
    </div>

</html>

@endsection