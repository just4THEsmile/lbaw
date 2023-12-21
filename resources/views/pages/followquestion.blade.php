@extends('layouts.barebone')

@section('sidebar')
<a class='aside' style="border-top: 4px solid black;" href="{{ route('profile', ['id' => $user->id]) }}" >{{$user->username}}'s Profile</a>
<a class='aside active' href="{{ route('followquestion', ['id' => $user->id]) }}">{{$user->username}}'s Followed Questions</a>
<a class='aside' href="{{ route('myquestions', ['id' => $user->id]) }}" >{{$user->username}}'s questions</a>
<a class='aside' href="{{ route('myanswers', ['id' => $user->id]) }}">{{$user->username}}'s answers</a>
@if(Auth::user()->id === $user->id)
<a class='aside' href="{{ route('myblocked', ['id' => $user->id]) }}">{{$user->username}}'s blocked content</a>
@endif
@endsection
@section('pagename')
{{$user->username}}'s Followed Questions
@endsection

@section('og')
    <meta property="og:title" content="{{$user->username}}'s Followed Questions" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url('/followquestion/'.$user->id) }}" />
    <meta property="og:description" content="{{$user->username}}'s Followed Questions" />
    <meta property="og:image" content="{{ $user->getProfileImage() }}" />
@endsection

@section('content2')
    <h2>{{$user->username}}'s Followed Questions</h2>
    <label for="sortSelect">Sort By:</label>
    <select id="sortSelect">
        <option value="date">Time</option>
        <option value="votes">Votes</option>
    </select>


<div id="user_id" hidden>{{$user->id}}</div>
    <div class="error" id="error"></div>
        <ul id="Questions"></ul>
        <div id ="pagination"></div>
        <script type="text/javascript" src={{ url('js/followedQuestions.js') }} defer></script>
@endsection

