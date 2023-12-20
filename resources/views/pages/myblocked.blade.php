@extends('layouts.barebone')

@section('styles')
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
@endsection
@section('pagename')
{{$user->username}}'s blocked content
@endsection  

@section('og')
    <meta property="og:title" content="{{$user->username}}'s blocked content" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url('/myblocked/'.$user->id) }}" />
    <meta property="og:description" content="{{$user->username}}'s blocked content" />
    <meta property="og:image" content="{{ $user->getProfileImage() }}" />
@endsection 

@section('sidebar')
<a class='aside' style="border-top: 4px solid black;" href="{{ route('profile', ['id' => $user->id]) }}" >{{$user->username}}'s Profile</a>
<a class='aside' href="{{ route('followquestion', ['id' => $user->id]) }}">{{$user->username}}'s Followed Questions</a>
<a class='aside' href="{{ route('myquestions', ['id' => $user->id]) }}" >{{$user->username}}'s questions</a>
<a class='aside' href="{{ route('myanswers', ['id' => $user->id]) }}">{{$user->username}}'s answers</a>
<a class='aside active' href="{{ route('myblocked', ['id' => $user->id]) }}">{{$user->username}}'s blocked content</a>

@endsection

@section('content2')


    <link href="{{ asset('css/blocked.css') }}" rel="stylesheet">
    <style>
        #MyBlocked{
            background-color: #0000FF;
            
        }
        #MyBlocked > a{
            color:white;
        } 
    </style>

    @if (session('message'))
        <div class="alert alert-info">
            {{ session('message') }}
        </div>
    @endif
    <div id="user_id" hidden>{{$user->id}}</div>
    <div class="card-container">
    <span class="error" id ="error"></span>
        @if($errors->has('content'))
            <span class="error">
                {{ $errors->first('content') }}
            </span>
        @endif
        @foreach ($blockedContent as $block)
            {{-- Check content type and include respective partial --}}
            @if ($block->type === 'question')
                @include('partials.blockedquestion', ['block' => $block])
            @elseif ($block->type === 'answer')
                @include('partials.blockeanswer', ['block' => $block])
            @elseif ($block->type === 'comment')
                @include('partials.blockecomment', ['block' => $block])
            @endif
        @endforeach
    
        <div class="d-flex justify-content-center mt-4">
            {{ $blockedContent->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection



@section('content3')
<div id='Profile'><a class='aside' href="{{ route('profile', ['id' => $user->id]) }}" >Profile</a></div>
<div id='Follow'><a class='aside' href="{{ route('followquestion', ['id' => $user->id]) }}">Followed Questions</a></div>
<div id='MyQuestions'><a class='aside' href="{{ route('myquestions', ['id' => $user->id]) }}" >My questions</a></div>
<div id= 'MyAnswers'><a class='aside' href="{{ route('myanswers', ['id' => $user->id]) }}">My answers</a></div>
<div id= 'MyBlocked'><a class='aside' href="{{ route('myblocked', ['id' => $user->id]) }}">My blocked</a></div>
@endsection