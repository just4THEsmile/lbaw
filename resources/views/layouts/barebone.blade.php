<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('pagename')</title>

        <!-- Styles -->
        @yield('style')
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="{{ url('css/milligram.min.css') }}" rel="stylesheet">
        <link href="{{ url('css/app.css') }}" rel="stylesheet">
        <link href="{{ url('css/profile.css') }}" rel="stylesheet">
        <link href="{{ url('css/question_card.css') }}" rel="stylesheet">
        <link href="{{ url('css/pagination.css') }}" rel="stylesheet">
        <link href="{{ url('css/search.css') }}" rel="stylesheet">
        <link href="{{ url('css/home.css') }}" rel="stylesheet">
        <link href="{{ url('css/tag.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link href="{{asset('images/webicon.ico')}}" rel = "icon">
        @yield('og')
        <script type="text/javascript">
            // Fix for Firefox autofocus CSS bug
            // See: http://stackoverflow.com/questions/18943276/html-5-autofocus-messes-up-css-loading/18945951#18945951
        </script>
        <script type="text/javascript" src={{ url('js/app.js') }} defer>
        </script>
    </head>
    <body>
        <main>
            <header >
                <h1><a href="{{ url('/home') }}">QthenA</a></h1>
                @if (Auth::check())
                    <div>
                        <a class="button" href="{{ url('/logout') }}"> Logout </a>  

                    </div>    

                @endif
            </header>
            <div class="sidebar">
                    <a href="/home">Home Page</a>
                    <a href="/feed">Feed</a>
                    <a href="{{'/tags'}}">Tags</a>
                    <a href="{{'/questions'}}">Questions</a>
                    <a href="{{'/users'}}" >Users</a>
                    @if (Auth::check() && (Auth::user()->usertype == 'admin' || Auth::user()->usertype == 'moderator'))
                        <a href="{{'/moderatecontent'}}">Blocked Content</a>
                    @endif
                    @yield('sidebar')

            </div>
        
        <div id='flexthis'>

            <div id='gridable' >
                @yield('content2')
            </div>

            
        </div>
        <div class="botoooom">
                <footer class="py-3 my-4">
                    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                    <li class="nav-item"><a href="/home" class="nav-link px-2 text-muted">Home</a></li>
                    <li class="nav-item"><a href="/faq" class="nav-link px-2 text-muted">FAQs</a></li>
                    <li class="nav-item"><a href="/about" class="nav-link px-2 text-muted">Contacts</a></li>
                    </ul>
                    <p class="text-center text-muted">© 2023 Company, Inc</p>
                </footer>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
        </main>
    </body>
</html>