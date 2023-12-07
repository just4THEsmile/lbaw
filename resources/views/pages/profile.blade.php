@extends('layouts.barebone')

@section('style')
<style>
        #Profile{
            background-color: #0000FF;
            
        }
        #Profile > a{
            color:white;
        } 
</style>
@endsection

@section('content2')
    <nav>
        <a id='arrow' href="{{'/users'}}" >&larr;</a>
    </nav>
    <section id='info'>
        <div id='container'>
            <div id="profile">
                    <img src="{{ $user->getProfileImage() }}" alt="Profile Picture">
            </div>
            <div id='username'>   
                <h1>{{ $user->username }}</h1>
            </div>
            
            <div id='paylink'>
                <a href="{{$user->paylink}}">Donate</a>
            </div>
            <div id='stats'>
                <div id='points'>
                    <div>Points</div>
                    <p>{{ $user->points}}</p>
                </div>
                <div id='questions'>
                    <div>Questions</div>
                    <p>{{ $user->nquestion }}</p>
                </div>
                <div id='answers'>
                    <div>Answers</div>
                    <p>{{ $user->nanswer }}</p>
                </div>	
            </div>
        </div>
        @if(Auth::user()->id === $user->id || Auth::user()->usertype === 'admin')
        <div id='edit'>
            <form method="POST" action="{{ route('deleteaccount',['id' => $user->id]) }}" onsubmit="return confirmDelete()">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <button type="submit" class="button">Delete Account</button>
            </form>
            <a class="button" href="{{ route('editprofile', ['id' => $user->id]) }}">Edit Profile</a>  
        </div>
        @endif
    </section>
        <section id='about'>
            <h3>About me</h3>
            <p>{{ $user->bio }}</p>
        </section>
        <section id='badges'>
            <h3>Badges Unlocked</h3>
            <ul>
                @foreach($user->badges as $badge)
                    <li>{{ $badge->name }} - {{ $badge->description }}</li>
                @endforeach
            </ul>
        </section>
        
@endsection

@section('content3')
<div id='Profile'><a class='aside' href="{{ route('profile', ['id' => $user->id]) }}" >Profile</a></div>
<div id='Follow'><a class='aside' href="{{ route('followquestion', ['id' => $user->id]) }}">Followed Questions</a></div>
<div id='MyQuestions'><a class='aside' href="{{ route('myquestions', ['id' => $user->id]) }}" >My questions</a></div>
<div id= 'MyAnswers'><a class='aside' href="{{ route('myanswers', ['id' => $user->id]) }}">My answers</a></div>
<div id= 'MyBlocked'><a class='aside' href="{{ route('myblocked', ['id' => $user->id]) }}">My blocked</a></div>
@endsection