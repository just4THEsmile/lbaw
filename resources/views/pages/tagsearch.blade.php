@extends('layouts.app')

@section('style')

    <link href="{{ asset('css/search.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tagpage.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

@endsection

@section('content')
<div class="sidebar">
  <a href="/home">Home Page</a>
  <a class="active" href="{{'/tags'}}">Tags</a>
  <a href="{{'/questions'}}">Questions</a>
  <a href="{{'/users'}}">Users</a>
  @if (Auth::check() && (Auth::user()->usertype == 'admin' || Auth::user()->usertype == 'moderator'))
    <a href="{{'/moderatecontent'}}">Blocked Content</a>
  @endif
</div>

<div style="color:white; font-size:0.0001em;">Home</div>

    <style>
        #MyAnswers{
            background-color: #0000FF;
            
        }
        #MyAnswers > a{
            color:white;
        } 
    </style>
    <div class="realcontent">
        <input id="searchTagInput"></input>
        <div id="user_type" hidden>{{ $user_type }}</div>
        @if(Auth::user() && Auth::user()->usertype === 'admin')
        <a class="createquestionbutton" href="{{ route('tagcreateform') }}"><button> Create Tag</button></a>
        @endif
        @if ($errors->has('tag'))
                <span class="error">
                    {{ $errors->first('tag') }}
                </span>
            @endif
        <ul id="Tags"></ul>
        <div id ="pagination"></div>
        <script src="{{ asset('js/tagSearch.js') }}" defer></script>
    </div>

@endsection
