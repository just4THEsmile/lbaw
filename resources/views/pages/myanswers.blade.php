@extends('layouts.barebone')

@section('content2')


    <style>
        #MyAnswers{
            background-color: #0000FF;
            
        }
        #MyAnswers > a{
            color:white;
        } 
    </style>
    @php
        $answers = $user->answers();
    @endphp
        @if($answers->isEmpty())
        <p>No questions found.</p>
        @else
        <ul>
        @foreach($answers as $answer)
        <div class= "answercard">
            <a class="title" href="{{ url('/question/'.$answer->id) }}">{{ $answer->title }}</a>
            <div class ="content">
                <p class="votes">{{ $answer->votes }}</p>
                <p >{{ $answer->content }}</p>
                <p class="date">{{ $answer->date }}</p>
            </div>
        </div>
        @endforeach
        </ul>
    @endif

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