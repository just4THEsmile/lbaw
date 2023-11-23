@extends('layouts.app')

@section('title', $question->title)
{{-- style--}}
@section('style')
    <link href="{{ asset('css/question.css') }}" rel="stylesheet">
@endsection

@section('content')

    <div class="sidebar">
    <a href="/home">Home Page</a>
    <a href="{{'/tags'}}">Tags</a>
    <a class="active" href="{{'/questions'}}">Questions</a>
    <a href="{{'/users'}}">Users</a>
    </div>

    <div style="color:white; font-size:0.0001em;">Home</div>
    <section id="answers">
        @include('partials.question', ['question' => $question])
    </section>
@endsection