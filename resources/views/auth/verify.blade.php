@extends('layouts.app')
@section ('style')
  <link href="{{ url('css/auth.css') }}" rel="stylesheet">
@endsection
@section('content')

<p>
    Hello {{ $user->name }}
</p>
<p>
    You have requested to reset your password. Please click the link below to reset your password.
</p>
<a class="button button-primary" href="{{ route('reset', ['token' => $user->remember_token]) }}">Reset Password</a>

@endsection