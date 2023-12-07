@extends('layouts.app')

@section('style')
    <link href="{{ url('css/editprofile.css') }}" rel="stylesheet">
@endsection
@section('content')
            <div class="container-xl px-4 mt-4">
            <!-- Account page navigation-->
            <div class="row">
                <div class="col-xl-4">
                    <!-- Profile picture card-->
                    <div class="card mb-4 mb-xl-0">
                        <div class="card-header">Profile Picture</div>
                        <p>Upload a profile picture to personalize your account.</p>
                        <div class="card-body text-center">
                            <img class="img-account-profile rounded-circle mb-2" src="{{ $user->getProfileImage() }}" alt="Profile Picture">
                            <form id='profileform' action="/file/upload" method='post' enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <input type="file" name="profilepicture" accept="image/png,image/jpeg,image/png" multiple>
                                <input name="type" type="text" value="profile" hidden>
                                <button class="btn btn-primary" type="submit" name="profile-form">Upload new image</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <!-- Account details card-->
                    <div class="card mb-4">
                        <div class="card-header">Account Details</div>
                        <div class="card-body">
                        <form id='userform' action="{{route('updateuser', ['id' => $user->id])}}" method='post'>
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputUsername">Username (how your name will appear to other users on the site)</label>
                                    @if ($errors->has('username'))
                                    <span class="error">
                                        {{ $errors->first('username') }}
                                    </span>
                                    @endif
                                    <input class="form-control" type="text" id="username" name="username" placeholder="Enter your username" value="{{$user->username}}">
                                </div>
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputUsername">Name</label>
                                    @if ($errors->has('name'))
                                    <span class="error">
                                        {{ $errors->first('name') }}
                                    </span>
                                    @endif
                                    <input class="form-control" type="text" id="name" name="name" placeholder="Enter your username" value="{{$user->name}}">
                                </div>
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputEmailAddress">Email address</label>
                                    @if ($errors->has('email'))
                                    <span class="error">
                                        {{ $errors->first('email') }}
                                    </span>
                                    @endif
                                    <input class="form-control" type="text" id="email"  name='email' value="{{$user->email}}" placeholder="Enter your email address">
                                </div>
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputPassword">New Password</label>
                                    @if ($errors->has('password'))
                                    <span class="error">
                                        {{ $errors->first('password') }}
                                    </span>
                                    @endif
                                    <input class="form-control" id="password" name="password" type="text" placeholder="Enter your Password" value="">
                                </div>
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputBio">Bio</label>
                                    @if ($errors->has('bio'))
                                    <span class="error">
                                        {{ $errors->first('bio') }}
                                    </span>
                                    @endif
                                    <textarea class="form-control" id="bio" name="bio" type="text" placeholder="Enter your Bio" >{{$user->bio}}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputBio">Paylink</label>
                                    @if ($errors->has('paylink'))
                                    <span class="error">
                                        {{ $errors->first('paylink') }}
                                    </span>
                                    @endif
                                    <input class="form-control" id="paylink" name="paylink" type="text" placeholder="Enter your paylink" value="{{$user->paylink}}">
                                </div>
                                <button  type='submit' class=' btn btn-primary submitbuttons' name="user-form">Save Changes</button>
                            </form>
                            @if(Auth::user()->usertype === 'admin')
                            <form id='useradminform' action="{{route('updateuseradmin', ['id' => $user->id])}}" method='post'>
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <h3>User Type</h3>
                                        <select name="usertype" id="usertype" class="form-select">
                                            <option value="user" @if($user->usertype === 'user') selected @endif>User</option>
                                            <option value="moderator" @if($user->usertype === 'moderator') selected @endif>Moderator</option>
                                            <option value="admin" @if($user->usertype === 'admin') selected @endif>Admin</option>
                                        </select>
                                        <h3>Badges</h3>
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
                                <button type='submit' class='btn btn-primary submitbuttons' name="useradminform">Save Changes</button>
                            </form>
                            @endif
                                </div>
                                
                        </div>
                    </div>
                </div>
            </div>
        
@endsection