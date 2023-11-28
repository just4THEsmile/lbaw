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
        <ul id="Tags"></ul>
        <div id ="TagsPagination"></div>
        <script src="{{ asset('js/tagSearch.js') }}" defer></script>
    </div>

@endsection
