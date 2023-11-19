@extends('layouts.barebone')

@section('content')

    @php
        $user = Auth::user();
        $profilePicturePath = $user->profilepicture;
    @endphp
    <section id='info'>
        <div id="profile">
            @if ($profilePicturePath)
                <img src="{{ asset('storage/' . $user->profilepicture) }}" alt="Profile Picture">
            @else
                <img src="{{ asset('images/space.png') }}" alt="Default Profile Image">
            @endif
        </div>
        <div id='username'>   
            <h1>{{ $user->username }}</h1>
        </div>
        <div id='paylink'>
            <a href="https://www.paypal.com/pt/home">Donate</a>
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