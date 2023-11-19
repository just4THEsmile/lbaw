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
                    <div id='Profile'><a class='aside' href="{{ url('/profile') }}" >Profile</a></div>
                    <div id='Follow'><a class='aside' href="{{ url('/followquestion') }}">Followed Questions</a></div>
                    <div id='MyQuestions'><a class='aside' href="{{ url('/myquestions') }}" >My questions</a></div>
                    <div id= 'MyAnswers'><a class='aside' href="{{ url('/myanswers') }}">My answers</a></div>
                    <div id='additional'>
                        <div>FAQ</div>
                        <div>About us</div>
                        <div>Contact us</div>
                        <div>Terms of service</div>
                    </div>
            </aside>
            <div id='gridable'>
                @yield('content')
            </div>
        </div>
    </body>
</html>