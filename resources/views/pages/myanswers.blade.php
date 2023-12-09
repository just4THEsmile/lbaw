@extends('layouts.barebone')

@section('style')
    <link href="{{ asset('css/question.css') }}" rel="stylesheet">
@endsection

@section('sidebar')

<a class='aside' style="border-top: 4px solid black;" href="{{ route('profile', ['id' => $user->id]) }}" >{{$user->username}}'s Profile</a>
<a class='aside' href="{{ route('followquestion', ['id' => $user->id]) }}">{{$user->username}}'s Followed Questions</a>
<a class='aside' href="{{ route('myquestions', ['id' => $user->id]) }}" >{{$user->username}}'s questions</a>
<a class='aside active' href="{{ route('myanswers', ['id' => $user->id]) }}">{{$user->username}}'s answers</a>
<a class='aside' href="{{ route('myblocked', ['id' => $user->id]) }}">{{$user->username}}'s blocked content</a>

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
