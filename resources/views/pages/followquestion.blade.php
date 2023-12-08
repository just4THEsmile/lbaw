@extends('layouts.barebone')

@section('sidebar')
<a class='aside' href="{{ route('profile', ['id' => $user->id]) }}" >Profile</a>
<a class='aside active' href="{{ route('followquestion', ['id' => $user->id]) }}">Followed Questions</a>
<a class='aside' href="{{ route('myquestions', ['id' => $user->id]) }}" >My questions</a>
<a class='aside' href="{{ route('myanswers', ['id' => $user->id]) }}">My answers</a>
<a class='aside' href="{{ route('myblocked', ['id' => $user->id]) }}">My blocked</a>

@endsection

@section('content2')

<style>
        #Follow{
            background-color: #0000FF;
            
        }
        #Follow > a{
            color:white;
        } 
</style>
    <label for="sortSelect">Sort By:</label>
    <select id="sortSelect">
        <option value="date">Time</option>
        <option value="votes">Votes</option>
    </select>

<div>Followed questions:</div>
<div>{{ $user->name }}'s followed questions</div>
<div id="user_id" hidden>{{$user->id}}</div>
        <ul id="Questions"></ul>
        <div id ="pagination"></div>
        <script type="text/javascript" src={{ url('js/followedQuestions.js') }} defer></script>
@endsection

