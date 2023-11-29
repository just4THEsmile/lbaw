@extends('layouts.app')

@section('content')

<p style="margin-top:6em">
    Hello {{ $user->name }}
</p>
<form method="POST" action="{{ route('resetpassword') }}">
    @csrf

    <label for="password">New Password</label>
    <input id="password" type="password" name="password" required>
    @if ($errors->has('password'))
      <span class="error">
          {{ $errors->first('password') }}
      </span>
    @endif

    <label for="password-confirm">Confirm New Password</label>
    <input id="password-confirm" type="password" name="password_confirmation" required>
    <input type="hidden" name="token" value="{{ $user->remember_token }}">
    <button type="submit">
      Confirm Changes
    </button>
</form>





@endsection