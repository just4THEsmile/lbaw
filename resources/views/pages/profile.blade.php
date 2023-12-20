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

@section('pagename')
{{ $user->username }}'s Profile
@endsection   

@section('sidebar')
<a class='aside active' style="border-top: 4px solid black;" href="{{ route('profile', ['id' => $user->id]) }}" >{{$user->username}}'s Profile</a>
<a class='aside' href="{{ route('followquestion', ['id' => $user->id]) }}">{{$user->username}}'s Followed Questions</a>
<a class='aside' href="{{ route('myquestions', ['id' => $user->id]) }}" >{{$user->username}}'s questions</a>
<a class='aside' href="{{ route('myanswers', ['id' => $user->id]) }}">{{$user->username}}'s answers</a>
@if(Auth::user()->id === $user->id)
<a class='aside' href="{{ route('myblocked', ['id' => $user->id]) }}">{{$user->username}}'s blocked content</a>
@endif
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
        </div>
        <div class="button" id='paylink'>
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
        
        @if(Auth::user()->id === $user->id || Auth::user()->usertype === 'admin')
        <div id='edit'>
            <form method="POST" action="{{ route('deleteaccount',['id' => $user->id]) }}" onsubmit="return confirmDelete()">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <button type="submit" class="button" style="text-transform: none !important;" >Delete Account</button>
            </form>
            @if(Auth::user()->usertype === 'admin')
            <form method="POST" action="{{ route('blockaccount',['id' => $user->id]) }}" onsubmit="return confirmBlock()">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                @if($user->blocked)
                <button type="submit" class="button" style="text-transform: none !important;" >Unblock Account</button>
                @else
                <button type="submit" class="button" style="text-transform: none !important;" >Block Account</button>
                @endif
            </form>
            @endif
            @if(Auth::user()->id === $user->id && $user->blocked)
            <form method="GET" action="{{ route('unblockaccountform', ['id' => Auth::user()->id]) }}">
                <button type="submit" class="button" style="text-transform: none !important;">Unblock Account Request</button>
            </form>
            @endif
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
                @foreach($badges as $badge)
                    <li><div class="badgecontent"><div class="flexbadge"><div class="badgename"><span>{{ $badge->badge->name }} </span></div><div class="badgedescription"> {{ $badge->badge->description }}</div></div><div class="badgedate"><span>{{$badge->date}}</span></div></div></li>
                @endforeach
            </ul>
        </section>
        
@endsection

