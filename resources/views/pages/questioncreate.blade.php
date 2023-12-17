@extends('layouts.app')

@section('style')
    <link href="{{ asset('css/createquestion.css') }}" rel="stylesheet">
    <link href="{{ asset('css/error.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tag.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

@endsection    

@section('content')
    <div class="sidebar">
        <a href="/home">Home Page</a>
        <a href="{{'/tags'}}">Tags</a>
        <a class="active" href="{{'/questions'}}">Questions</a>
        <a href="{{'/users'}}">Users</a>
        @if (Auth::check() && (Auth::user()->usertype == 'admin' || Auth::user()->usertype == 'moderator'))
            <a href="{{'/moderatecontent'}}">Blocked Content</a>
        @endif
    </div>
    <div class="create">
        <div class="forms">
                <div id="questionerror" class="error"></div>
                <div class="form-group">
                    <div id="titleError" class="error"></div>
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="form-group">
                <span id="contentError" class="error"></span>
                    <label for="content">Content:</label>
                    <textarea class="form-control" id="questionContent" name="content" rows="4" required></textarea>
                </div>
                <div id="selectedtags">
                </div>
                <div id="errorAddTag" class="error"></div>
                <label>Add Tags:</label>
                <input type="text" class="form-control" id="TagsInput" name="title" value="" required>
                <div id="autocomplete"></div>
                <button id="submitbutton" class="btn btn-primary">Submit</button>
            </div>
        </div>    
    </div>    
    <script type="text/javascript" src={{ url('js/create_question_form.js') }} defer></script>
@endsection