@extends('layouts.barebone')

@section('sidebar')
<a class='aside' href="{{ route('profile', ['id' => $user->id]) }}" >Profile</a>
<a class='aside' href="{{ route('followquestion', ['id' => $user->id]) }}">Followed Questions</a>
<a class='aside active' href="{{ route('myquestions', ['id' => $user->id]) }}" >My questions</a>
<a class='aside' href="{{ route('myanswers', ['id' => $user->id]) }}">My answers</a>
<a class='aside' href="{{ route('myblocked', ['id' => $user->id]) }}">My blocked</a>

@endsection

@section('content2')

    <style>
        #MyQuestions{
            background-color: #0000FF;
            
        }
        #MyQuestions > a{
            color:white;
        } 
    </style>
    <div id="user_id" hidden>{{$user->id}}</div>
    <label for="sortSelect">Sort By:</label>
        <select id="sortSelect">
            <option value="date">Time</option>
            <option value="votes">Votes</option>
        </select>
        <ul id="Questions"></ul>
        <div id ="pagination"></div>
        <script type="text/javascript" src={{ url('js/my_questions.js') }} defer></script>
@endsection



@section('content3')
<div id='Profile'><a class='aside' href="{{ route('profile', ['id' => $user->id]) }}" >Profile</a></div>
<div id='Follow'><a class='aside' href="{{ route('followquestion', ['id' => $user->id]) }}">Followed Questions</a></div>
<div id='MyQuestions'><a class='aside' href="{{ route('myquestions', ['id' => $user->id]) }}" >My questions</a></div>
<div id= 'MyAnswers'><a class='aside' href="{{ route('myanswers', ['id' => $user->id]) }}">My answers</a></div>
<div id= 'MyBlocked'><a class='aside' href="{{ route('myblocked', ['id' => $user->id]) }}">My blocked</a></div>
@endsection