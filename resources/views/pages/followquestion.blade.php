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
<div id="user_id" hidden>{{$user->id}}</div>
        <ul id="Answers"></ul>
        <div id ="AnswerPagination"></div>
        <script type="text/javascript" src={{ url('js/followedQuestions.js') }} defer></script>
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