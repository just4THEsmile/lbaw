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
        <link href="{{ url('css/app.css') }}" rel="stylesheet">
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
                    <a class="button" href="{{ url('/logout') }}"> Logout </a> <a class="button" href="{{ url('/profile') }}">Go back</a>
                @endif
            </header>
            <section id='edits'>
                <div id='namecard' class='card'>
                    <div class='left-card'>
                        <h1>Name</h1>
                        <p>Here you can change your name, which is used to identify you within the system. Your name may be displayed on your profile, on messages you send, and in other areas where your identity is relevant. Updating your name can help ensure that you are recognized accurately and consistently by other users or participants in the system.</p>
                    </div>
                    <div class='right-card'>                   
                        <form id='nameform' action="{{route('updatename')}}" method='post'>
                            @csrf
                            <input type="text" id="name" name="name" value="{{Auth::user()->name}}">
                            <button type="submit" class='submitbuttons' name="name-form">Save Changes</button>
                        </form>
                    </div>   
                </div>
                <div id='usernamecard' class='card'>
                    <div class='left-card'>
                        <h1>Username</h1>
                        <p>Here you can change your username, which is a unique identifier used to distinguish you from other users within the system. Your username may be displayed on your profile, in messages you send, and in other areas where your identity is relevant. Updating your username can help ensure that you are recognized accurately and consistently by other users or participants in the system.</p>
                    </div>
                    <div class='right-card'>
                        <form id='usernameform' action="{{route('updateusername')}}" method='post'>
                            @csrf
                            <input type="text" id="username" name='username' value="{{Auth::user()->username}}">
                            <button type='submit' class='submitbuttons' name="username-form">Save Changes</button>
                        </form>
                    </div>   
                </div>
                <div id='emailcard' class='card'>
                    <div class='left-card'>
                        <h1>Email</h1>
                        <p>Here you can update the email address associated with your account. This email address is used to communicate with you regarding your account, such as password resets or notifications. Please ensure that the email address you provide is accurate and up-to-date to avoid missing important messages.</p>
                    </div>
                    <div class='right-card'>
                        <form id='emailform' action="{{route('updatemail')}}" method='post'>
                            @csrf
                            <input type="text" id="email"  name='email' value="{{Auth::user()->email}}">
                            <button type='submit' class='submitbuttons' name="email-form">Save Changes</button>
                        </form>
                    </div>    
                </div>
                <div id='passwordcard' class='card'>
                    <div class='left-card'>
                        <h1>Password</h1>
                        <p>Here you can update your password, which is used to secure your account and protect your data within the system. Keeping a strong and unique password can help prevent unauthorized access to your account, so we recommend using a combination of letters, numbers, and symbols. It's also a good practice to change your password regularly to keep your account safe.</p>
                    </div>
                    <div class='right-card'>
                        <form id='passwordform' action="{{route('updatepassword')}}" method='post'>
                            @csrf
                            <input type="text" id="password" name='password' value="">
                            <button type='submit' class='submitbuttons' name="password-form">Save Changes</button>
                        </form>
                    </div>   
                </div>
                <div id='biocard' class='card'>
                    <div class='left-card'>
                        <h1>Bio</h1>
                        <p>Here you can enter a short biography, which will be displayed on your profile page. You may wish to include information about your background, interests, or current activities. Keep in mind that this information will be visible to other users or participants in the system.</p>
                    </div>
                    <div class='right-card'>
                        <form id='bioform' action="{{route('updatebio')}}" method='post'>
                            @csrf
                            <textarea id="bio" name='bio'>{{Auth::user()->bio}}</textarea>
                            <button type='submit' class='submitbuttons' name="bio-form">Save Changes</button>
                        </form>
                    </div>  
                </div>
                <div id='profilecard' class='card'>
                    <div class='left-card'>
                        <h1>Profile</h1>
                        <p>Here you can change your profile picture, which is used to represent you within the system. Your profile picture may be displayed on your profile, on messages you send, and in other areas where your identity is relevant. Updating your profile picture can help ensure that you are recognized accurately and consistently by other users or participants in the system.</p>
                    </div>
                    <div class='right-card'>
                    <form id='profileform' action="{{route('updateprofilepicture')}}" method='post' enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="profilepicture" accept="image/png,image/jpeg" multiple>
                        <button type='submit' class='submitbuttons' name='profile-form'>Save Changes</button>
                    </form>
                    </div>   
                </div>
                <div id='paylinkcard' class='card'>
                    <div class='left-card'>
                        <h1>PayLink</h1>
                        <p>Here you can change your paypal link, which is used to receive donations from other users.</p>
                    </div>
                    <div class='right-card'>
                        <form id='paylinkform' action="{{route('updatepaylink')}}" method='post'>
                            @csrf
                            <input type="url" id="paylink" name='paylink' value="{{ Auth::user()->paylink }}" placeholder="Enter your PayPal link" required>
                            <button type='submit' class='submitbuttons' name="bio-paylink">Save Changes</button>
                        </form>
                    </div>  
                </div>
            </section>
        </main>
    </body>
</html>
            

