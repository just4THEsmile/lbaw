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