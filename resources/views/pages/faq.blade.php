@extends('layouts.app')
@section('style')
    <link href="{{ url('css/faq.css') }}" rel="stylesheet">
@endsection
@section('pagename')
FAQ
@endsection 

@section ('content')
    <div class="sidebar">
    <a href="/home">Home Page</a>
    <a href="/feed">Feed</a>
    <a href="{{'/tags'}}">Tags</a>
    <a href="{{'/questions'}}">Questions</a>
    <a href="{{'/users'}}">Users</a>
    @if (Auth::check() && (Auth::user()->usertype == 'admin' || Auth::user()->usertype == 'moderator'))
        <a href="{{'/moderatecontent'}}">Blocked Content</a>
    @endif
    </div>
    <div class="faq-container">
        <h1>Frequently Asked Questions</h1>
        <div class="faq-list">
            @foreach ($faqs as $faq)
                <div class="faq-item">
                    <div class="faq-question">
                        <h2>{{ $faq->question }}</h2>
                        <span class="toggle-btn">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>{{ $faq->answer }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script src="{{ asset('js/faq.js') }}"></script>
@endsection
