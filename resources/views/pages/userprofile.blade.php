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
        <script type="text/javascript" src={{ url('js/app.js') }} defer></script>
    </head>
    <body>
        <main>
            <header>
                <h1><a href="{{ url('/home') }}">QthenA</a></h1>
                @if (Auth::check())
                     <a class="button" href="{{ route('profile', ['id' => $user->id]) }}">Go back</a>
                @endif
            </header>
            <section id='edits'>
                <h1>Profile Settings</h1>
                <form id='userform' action="{{route('updateuser', ['id' => $user->id])}}" method='post'>
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div id='namecard' class='card'>
                        <div class='left-card'>
                            <h1>Name</h1>
                            <p>Here you can change your name, which is used to identify you within the system. Your name may be displayed on your profile, on messages you send, and in other areas where your identity is relevant. Updating your name can help ensure that you are recognized accurately and consistently by other users or participants in the system.</p>
                            @if ($errors->has('name'))
                            <span class="error">
                                {{ $errors->first('name') }}
                            </span>
                            @endif
                        </div>
                        <div class='right-card'>                    
                                <input type="text" id="name" name="name" value="{{$user->name}}">
                        </div>   
                    </div>
                    <div id='usernamecard' class='card'>
                        <div class='left-card'>
                            <h1>Username</h1>
                            <p>Here you can change your username, which is a unique identifier used to distinguish you from other users within the system. Your username may be displayed on your profile, in messages you send, and in other areas where your identity is relevant. Updating your username can help ensure that you are recognized accurately and consistently by other users or participants in the system.</p>
                            @if ($errors->has('username'))
                            <span class="error">
                                {{ $errors->first('username') }}
                            </span>
                            @endif
                        </div>
                        <div class='right-card'>
                                <input type="text" id="username" name='username' value="{{$user->username}}">
                        </div>   
                    </div>
                    <div id='emailcard' class='card'>
                        <div class='left-card'>
                            <h1>Email</h1>
                            <p>Here you can update the email address associated with your account. This email address is used to communicate with you regarding your account, such as password resets or notifications. Please ensure that the email address you provide is accurate and up-to-date to avoid missing important messages.</p>
                            @if ($errors->has('email'))
                            <span class="error">
                                {{ $errors->first('email') }}
                            </span>
                            @endif
                        </div>
                        <div class='right-card'>
                                <input type="text" id="email"  name='email' value="{{$user->email}}">
                        </div>
                            
                    </div>
                    <div id='passwordcard' class='card'>
                        <div class='left-card'>
                            <h1>Password</h1>
                            <p>Here you can update your password, which is used to secure your account and protect your data within the system. Keeping a strong and unique password can help prevent unauthorized access to your account, so we recommend using a combination of letters, numbers, and symbols. It's also a good practice to change your password regularly to keep your account safe.</p>
                        </div>
                        @if ($errors->has('password'))
                            <span class="error">
                                {{ $errors->first('password') }}
                            </span>
                        @endif
                        <div class='right-card'>
                                <input type="text" id="password" name='password' value="">
                        </div>   
                    </div>
                    <div id='biocard' class='card'>
                        <div class='left-card'>
                            <h1>Bio</h1>
                            <p>Here you can enter a short biography, which will be displayed on your profile page. You may wish to include information about your background, interests, or current activities. Keep in mind that this information will be visible to other users or participants in the system.</p>
                            @if ($errors->has('bio'))
                            <span class="error">
                                {{ $errors->first('bio') }}
                            </span>
                            @endif
                        </div>
                        <div class='right-card'>
                                <textarea id="bio" name='bio'>{{$user->bio}}</textarea>
                        </div>  
                    </div>
                    <div id='paylinkcard' class='card'>
                        <div class='left-card'>
                            <h1>PayLink</h1>
                            <p>Here you can change your paypal link, which is used to receive donations from other users.</p>
                            @if ($errors->has('paylink'))
                            <span class="error">
                                {{ $errors->first('paylink') }}
                            </span>
                            @endif
                        </div>
                        <div class='right-card'>
                                <input type="url" id="paylink" name='paylink' value="{{ $user->paylink }}" placeholder="Enter your PayPal link" required>
                        </div>  
                    </div>
                    <button type='submit' class='submitbuttons' name="user-form">Save Changes</button>
                </form>
                <div id='profilecard' class='card'>
                    <div class='left-card'>
                        <h1>Profile</h1>
                        <p>Here you can change your profile picture, which is used to represent you within the system. Your profile picture may be displayed on your profile, on messages you send, and in other areas where your identity is relevant. Updating your profile picture can help ensure that you are recognized accurately and consistently by other users or participants in the system.</p>
                    </div>
                    <div class='right-card'>
                        <form id='profileform' action="/file/upload" method='post' enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <input type="file" name="profilepicture" accept="image/png,image/jpeg,image/png" multiple>
                            <input name="type" type="text" value="profile" hidden>
                            <button type='submit' class='submitbuttons' name='profile-form'>Save Changes</button>
                        </form>
                    </div>   
                </div>
                @if(Auth::user()->usertype === 'admin')
                <form id='useradminform' action="{{route('updateuseradmin', ['id' => $user->id])}}" method='post'>
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div id='typecard' class='card'>
                        <div class='left-card'>
                            <h1>User Type</h1>
                            <p>Here you can change your user type, which is used to distinguish you from other users within the system. </p>
                        </div>
                        <div class='right-card'>
                            <select name="usertype" id="usertype">
                                <option value="user" @if($user->usertype == 'user') selected @endif>User</option>
                                <option value="moderator" @if($user->usertype == 'moderator') selected @endif>Moderator</option>
                                <option value="admin" @if($user->usertype == 'admin') selected @endif>Admin</option>
                            </select>
                        </div>
                    </div>
                    <div id='badgescard' class='card'>
                        <div class='left-card'>
                            <h1>Badges</h1>
                            <p>Here you can change your badges, which are used to distinguish you from other users within the system. </p>
                        </div>            
                        <div class='right-card'>
                            @php $badges = App\Models\Badge::all(); @endphp
                            @php $userbadges = $user->badges()->get()->pluck('id')->toArray(); @endphp
                            @foreach($badges as $badge)
                                <label>
                                    <input type='checkbox' name='badges[]' value='{{ $badge->id }}' {{ in_array($badge->id, $userbadges) ? 'checked' : '' }}>
                                    {{ $badge->name }}
                                </label> 
                            @endforeach
                        </div>
                    </div>
                    <button type='submit' class='submitbuttons' name="useradminform">Save Changes</button>
                </form>
                @endif
            </section>
        </main>
    </body>
</html>
            

