@extends('layouts.app')

@section('style')
    <link href="{{ asset('css/createquestion.css') }}" rel="stylesheet">
    <link href="{{ asset('css/errors.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tag.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

@endsection
@section('pagename')
Edit Question
@endsection    

@section('content')
    <div class="sidebar">
        <a href="/home">Home Page</a>
        <a href="/feed">Feed</a>
        <a href="{{'/tags'}}">Tags</a>
        <a class="active" href="{{'/questions'}}">Questions</a>
        <a href="{{'/users'}}">Users</a>
        @if (Auth::check() && (Auth::user()->usertype == 'admin' || Auth::user()->usertype == 'moderator'))
            <a href="{{'/moderatecontent'}}">Blocked Content</a>
        @endif
    </div>
    <div class="create">
        <div class="forms">
            <h1 style=" display:flex;    justify-content: center;">Edit a Question</h1>
            <div id="questionerror" class="error"></div>
            <input id="questionid" hidden value="{{ $question->id }}">
            <div class="form-group">
                <div id="titleError" class="error"></div>
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ $question->title}}" placeholder="Enter Your Question Title" required>
            </div>
            <div class="form-group">
            <span id="contentError" class="error"></span>
                <label for="questionContent">Content:</label>
                <textarea class="form-control" id="questionContent" name="content" rows="4" placeholder="Enter Your Question Content" required>{{ $question->commentable->content->content}}</textarea>
            </div>
            <div id="selectedtags">
            </div>
            <div id="errorAddTag" class="error"></div>
            <label>Add Tags:</label>
            <input type="text" class="form-control" id="TagsInput" name="title" value="" placeholder="Enter your tags here" required>
            <div id="autocomplete"></div>
            <button id="submitbutton" class="btn btn-primary">Submit</button>
        </div>    
    </div>
    <script type="text/javascript" src={{ url('js/edit_question_form.js') }} defer></script>
@endsection