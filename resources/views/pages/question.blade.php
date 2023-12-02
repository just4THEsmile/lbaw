@extends('layouts.app')

@section('title', $question->title)
{{-- style--}}
@section('style')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="{{ asset('css/question.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="sidebar">
    <a href="/home">Home Page</a>
    <a href="{{'/tags'}}">Tags</a>
    <a class="active" href="{{'/questions'}}">Questions</a>
    <a href="{{'/users'}}">Users</a>
    <a href="{{'/moderatecontent'}}">Blocked Content</a>
    </div>

    <div style="color:white; font-size:0.0001em;">Home</div>
    <section id="answers">
        @include('partials.question', ['question' => $question])
    </section>
@endsection