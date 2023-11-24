@extends('layouts.barebone')

@section('content2')

<style>
        #Follow{
            background-color: #0000FF;
            
        }
        #Follow > a{
            color:white;
        } 
</style>
<div>{{ $user->name }}'s followed questions</div>
<div>Followed questions:</div>
<ul id='followedquestions'>
    @foreach($followedQuestions as $followedQuestion)
        <div class="answercard">
            <a class="title" href="{{ url('/question/'.$followedQuestion->question_id) }}">{{ $followedQuestion->title }}</a>
            <div class="content">
                <p class="votes">ID:{{ $followedQuestion->id }}</p>
                <p class="question-body">{{ $followedQuestion->commentable->content->content }}</p>
            </div>
        </div>
    @endforeach
</ul>

@endsection

@section('content3')
<div id='Profile'><a class='aside' href="{{ route('profile', ['id' => $user->id]) }}" >Profile</a></div>
<div id='Follow'><a class='aside' href="{{ route('followquestion', ['id' => $user->id]) }}">Followed Questions</a></div>
<div id='MyQuestions'><a class='aside' href="{{ route('myquestions', ['id' => $user->id]) }}" >My questions</a></div>
<div id= 'MyAnswers'><a class='aside' href="{{ route('myanswers', ['id' => $user->id]) }}">My answers</a></div>
<div id='additional'>
    <div>FAQ</div>
    <div>About us</div>
    <div>Contact us</div>
    <div>Terms of service</div>
</div>
@endsection