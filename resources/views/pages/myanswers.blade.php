@extends('layouts.barebone')

@section('sidebar')

<a class='aside' href="{{ route('profile', ['id' => $user->id]) }}" >Profile</a>
<a class='aside' href="{{ route('followquestion', ['id' => $user->id]) }}">Followed Questions</a>
<a class='aside' href="{{ route('myquestions', ['id' => $user->id]) }}" >My questions</a>
<a class='aside active' href="{{ route('myanswers', ['id' => $user->id]) }}">My answers</a>
<a class='aside' href="{{ route('myblocked', ['id' => $user->id]) }}">My blocked</a>

@endsection


@section('content2')


    <style>
        #MyAnswers{
            background-color: #0000FF;
            
        }
        #MyAnswers > a{
            color:white;
        } 
    </style>
    <div id="user_id" hidden>{{$user->id}}</div>
    <label for="sortSelect">Sort By:</label>
    <select id="sortSelect">
        <option value="date">Time</option>
        <option value="votes">Votes</option>
    </select>
    <span class="error" id ="error"></span>
        <ul id="Answers"></ul>
        <div id ="pagination"></div>
        <script type="text/javascript" src={{ url('js/my_answers.js') }} defer></script>

@endsection
