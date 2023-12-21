@extends('layouts.app')

@section('title', $question->title)
{{-- style--}}
@section('style')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="{{ asset('css/question.css') }}" rel="stylesheet">
@endsection
@section('pagename')
{{$question->title}}
@endsection  

@section('og')
    <meta property="og:title" content="{{$question->title}}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url('/question/'.$question->id) }}" />
    <meta property="og:description" content="{{$question->commentable->content->content}}" />
    <meta property="og:image" content="{{ $question->commentable->content->user->getProfileImage() }}" />
@endsection

@section('content')
    
    <div class="sidebar">
    <a href="/home">Home Page</a>
    <a href="/feed">Feed</a>
    <a href="{{'/tags'}}">Tags</a>
    <a class="active" href="{{'/questions'}}">Questions</a>
    <a href="{{'/users'}}">Users</a>
    @if (Auth::check() && (Auth::user()->usertype === 'admin' || Auth::user()->usertype === 'moderator'))
    <a href="{{'/moderatecontent'}}">Blocked Content</a>
    @endif
    </div>

    <div style="color:white; font-size:0.0001em;">Home</div>
    <section id="answers">
        <div id="error" class="error">
            @if ($errors->has('question'))
                {{ $errors->first('question') }}
            @endif
        </div>
        @include('partials.question', ['question' => $question,'answers' => $answers])
        {{ $answers->links() }}
    </section>
    <script type="text/javascript" src={{ url('js/question.js') }} defer></script>
@endsection