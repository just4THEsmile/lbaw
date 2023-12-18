@extends('layouts.app')
@section ('style')
  <link href="{{ url('css/auth.css') }}" rel="stylesheet">
@endsection
@section('content')

<p style="margin-top:6em">
    Hello {{ $user->name }}
</p>
<form class="form" method="POST" action="{{ route('resetpassword') }}">
    @csrf

    <label for="password">New Password</label>
    <input id="password" type="password" name="password" placeholder="Enter Your New Password" required>
    @if ($errors->has('password'))
      <span class="error">
          {{ $errors->first('password') }}
      </span>
    @endif

    <label for="password-confirm">Confirm New Password</label>
    <input id="password-confirm" type="password" name="password_confirmation" placeholder="Enter Your New Password Again" required>
    <input type="hidden" name="token" value="{{ $user->remember_token }}">
    <button class="button-submit" type="submit">
      Confirm Changes
    </button>
</form>



@endsection