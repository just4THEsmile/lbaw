@extends('layouts.app')

@section('style')
  <link href="{{ asset('css/tag.css') }}" rel="stylesheet">
  <link href="{{ asset('css/question_card.css') }}" rel="stylesheet">
  <link href="{{ asset('css/home.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <link href="{{ asset('css/pagination.css') }}" rel="stylesheet">
@endsection


@section('title', 'content')

@section('content')
<div class="sidebar">
  <a class="active" href="/home">Home Page</a>
  <a href="/feed">Feed</a>
  <a href="{{'/tags'}}">Tags</a>
  <a href="{{'/questions'}}">Questions</a>
  <a href="{{'/users'}}">Users</a>
  @if (Auth::check() && (Auth::user()->usertype === 'admin' || Auth::user()->usertype === 'moderator'))
    <a href="{{'/moderatecontent'}}">Blocked Content</a>
  @endif
</div>

<div style="color:white; font-size:0.0001em;">Home</div>
  <div class="questionslist"> 
  <a class="createquestionbutton" href="./createquestion"><button> Create Question</button></a>
  @foreach ($questions as $question)


  <div class= "question">
    @if($question->correct_answer_id !== null)
      <div class="correct" style="display: flex;color: green;align-items: center;"><span class="material-symbols-outlined">check</span></div>
    @endif  
    
    <div class="votes">
      <p class= "answersnum" class=>{{ $question->answernum}} answers</p>
      <p class="votesnum" class=>{{ $question->commentable->content->votes }} votes</p> 
    </div>
    <div class ="content">
    <a href="{{ url('/question/'.$question->id) }}"><h3>{{ $question->title }}</h3></a>
      <div class="questionbottom">
        <div class="tags">
          @foreach($question->Tags() as $tag)
            <div class="tag"><a href="{{ url('/tag/'.$tag->id) }}">{{ $tag->title }}</a></div>
          @endforeach
        </div>  
        <div class="profileinfo">
          <a href="{{ url('/profile/'.$question->userid) }}">{{ $question->commentable->content->user->username }}</a>
          <p>{{ $question->commentable->content->compileddate() }}</p>
        </div>
      </div>  
    </div>
  </div>
@endforeach
{{ $questions->links() }}
</div>

@endsection
