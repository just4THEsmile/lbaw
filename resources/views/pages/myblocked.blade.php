@extends('layouts.barebone')

@section('content2')
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">


    <style>
        #MyBlocked{
            background-color: #0000FF;
            
        }
        #MyBlocked > a{
            color:white;
        } 
    </style>
    <div id="user_id" hidden>{{$user->id}}</div>
    <ul id="Blocked">
        @foreach($blockedContent as $block)
           <div class="blocked">
                <p>{{$block->content}}</p>
                <a href="/api/unblockrequest/{{ $block->id }}?user_id={{ $block->user_id }}" class="unblock">Request Unblock</a>
           </div>
        @endforeach
    </ul>
    <div class="d-flex justify-content-center mt-4">
        {{ $blockedContent->links('pagination::bootstrap-4') }}
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
@endsection



@section('content3')
<div id='Profile'><a class='aside' href="{{ route('profile', ['id' => $user->id]) }}" >Profile</a></div>
<div id='Follow'><a class='aside' href="{{ route('followquestion', ['id' => $user->id]) }}">Followed Questions</a></div>
<div id='MyQuestions'><a class='aside' href="{{ route('myquestions', ['id' => $user->id]) }}" >My questions</a></div>
<div id= 'MyAnswers'><a class='aside' href="{{ route('myanswers', ['id' => $user->id]) }}">My answers</a></div>
<div id= 'MyBlocked'><a class='aside' href="{{ route('myblocked', ['id' => $user->id]) }}">My blocked</a></div>
@endsection