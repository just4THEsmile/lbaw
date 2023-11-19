<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link href="{{ url('css/milligram.min.css') }}" rel="stylesheet">
        <link href="{{ url('css/profile.css') }}" rel="stylesheet">
        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script type="text/javascript" src={{ url('js/app.js') }} defer>
        </script>
    </head>
    <body>
        <main>
            <header>
                <h1><a href="{{ url('/home') }}">QthenA</a></h1>
                @if (Auth::check())
                    <div>
                        <a class="button" href="{{ url('/logout') }}"> Logout </a>  
                        <a class="button" href="{{ url('/editprofile') }}">Edit Profile</a>  
                        <a class="button" href="{{ url('/home') }}">Go back</a>
                    </div>    

                @endif
            </header>
        </main>
        <div id='flexthis'>
            <aside>
                    <div id='Follow'><button class='aside'>Followed Questions</button></div>
                    <div id='MyQuestions'><button class='aside'>My questions</button></div>
                    <div id= 'MyAnswers'><button class='aside'>My answers</button></div>
                    <div id='additional'>
                        <div>FAQ</div>
                        <div>About us</div>
                        <div>Contact us</div>
                        <div>Terms of service</div>
                    </div>
            </aside>
            <div id='gridable'>
                
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
            </div>
        </div>
    </body>
</html>