@extends('layouts.barebone')

@section('og')
    <meta property="og:title" content="{{$user->username}}'s questions" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url('/myquestions/'.$user->id) }}" />
    <meta property="og:description" content="{{$user->username}}'s questions" />
    <meta property="og:image" content="{{ $user->getProfileImage() }}" /> 
@endsection

@section('sidebar')
<a class='aside' style="border-top: 4px solid black;" href="{{ route('profile', ['id' => $user->id]) }}" >{{$user->username}}'s Profile</a>
<a class='aside' href="{{ route('followquestion', ['id' => $user->id]) }}">{{$user->username}}'s Followed Questions</a>
<a class='aside active' href="{{ route('myquestions', ['id' => $user->id]) }}" >{{$user->username}}'s questions</a>
<a class='aside' href="{{ route('myanswers', ['id' => $user->id]) }}">{{$user->username}}'s answers</a>
@if(Auth::user()->id === $user->id)
<a class='aside' href="{{ route('myblocked', ['id' => $user->id]) }}">{{$user->username}}'s blocked content</a>
@endif
@endsection

@section('pagename')
{{$user->username}}'s questions
@endsection   

@section('content2')

    <div id="user_id" hidden>{{$user->id}}</div>
    <h2>{{$user->username}}'s questions</h2>
    <label for="sortSelect">Sort By:</label>
        <select id="sortSelect">
            <option value="date">Time</option>
            <option value="votes">Votes</option>
        </select>
        <div class="error" id="error"></div>
        <span class="error" id ="error"></span>
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