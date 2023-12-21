@extends('layouts.barebone')

@section('style')
    <link href="{{ asset('css/question.css') }}" rel="stylesheet">
@endsection
@section('pagename')
{{$user->username}}'s answers
@endsection 

@section('og')
    <meta property="og:title" content="{{$user->username}}'s answers" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url('/myanswers/'.$user->id) }}" />
    <meta property="og:description" content="{{$user->username}}'s answers" />
    <meta property="og:image" content="{{ $user->getProfileImage() }}" />

@section('sidebar')

<a class='aside' style="border-top: 4px solid black;" href="{{ route('profile', ['id' => $user->id]) }}" >{{$user->username}}'s Profile</a>
<a class='aside' href="{{ route('followquestion', ['id' => $user->id]) }}">{{$user->username}}'s Followed Questions</a>
<a class='aside' href="{{ route('myquestions', ['id' => $user->id]) }}" >{{$user->username}}'s questions</a>
<a class='aside active' href="{{ route('myanswers', ['id' => $user->id]) }}">{{$user->username}}'s answers</a>
@if(Auth::user()->id === $user->id)
<a class='aside' href="{{ route('myblocked', ['id' => $user->id]) }}">{{$user->username}}'s blocked content</a>
@endif
@endsection


@section('content2')


    <div id="user_id" hidden>{{$user->id}}</div>
    <h2>{{$user->username}}'s answers</h2>
    <label for="sortSelect">Sort By:</label>
    <select id="sortSelect">
        <option value="date">Time</option>
        <option value="votes">Votes</option>
    </select>
    <div class="error" id="error"></div>
        <ul style="margin-left:0em;"id="Answers"></ul>
        <div id ="pagination"></div>
        <script type="text/javascript" src={{ url('js/my_answers.js') }} defer></script>

@endsection
