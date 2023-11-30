@extends('layouts.barebone')

@section('content2')

    <style>
        #MyQuestions{
            background-color: #0000FF;
            
        }
        #MyQuestions > a{
            color:white;
        } 
    </style>
    <div id="user_id" hidden>{{$user_id}}</div>
        <ul id="Questions"></ul>
        <div id ="QuestionPagination"></div>
        <script type="text/javascript" src={{ url('js/my_questions.js') }} defer></script>
@endsection



@section('content3')
<div id='Profile'><a class='aside' href="{{ route('profile', ['id' => $user_id]) }}" >Profile</a></div>
<div id='Follow'><a class='aside' href="{{ route('followquestion', ['id' => $user_id]) }}">Followed Questions</a></div>
<div id='MyQuestions'><a class='aside' href="{{ route('myquestions', ['id' => $user_id]) }}" >My questions</a></div>
<div id= 'MyAnswers'><a class='aside' href="{{ route('myanswers', ['id' => $user_id]) }}">My answers</a></div>
@endsection