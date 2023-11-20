@extends('layouts.app')

@section('title', 'content')

@section('content')
<div class="sidebar">
  <a class="active" href="/home">Home Page</a>
  <a href="{{'/tags'}}">Tags</a>
  <a href="{{'/questions'}}">Questions</a>
  <a href="{{'/users'}}">Users</a>
</div>

<div class="realcontent">
@foreach ($questions as $question)


<div class= "answercard">
    <a href="{{ url('/question/'.$question->id) }}">{{ $question->title }}</a>
    <div class ="content">
    <p class="votes">{{ $question->votes }}</p>
    <p>{{ $question->content }}</p>
    <a href="{{ url('/profile/'.$question->userid) }}">{{ $question->username }}</a>
    <p>{{ $question->date }}</p>
    </div>
</div>
@endforeach
</div>

@endsection
