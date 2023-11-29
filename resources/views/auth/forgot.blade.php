@extends('layouts.app')

@section('content')

<form method="POST" action="{{ route('password') }}">
    @csrf
    <h2>Forgot Password?</h2>
    <p>Please insert your email to send a password reset link.</p>
    <label for="email">E-mail</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    @if ($errors->has('email'))
        <span class="error">
          {{ $errors->first('email') }}
        </span>
    @endif
    <button type="submit">
        Send Password Reset Link
    </button>
</form>

@endsection