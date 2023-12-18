@extends('layouts.app')
@section ('style')
  <link href="{{ url('css/auth.css') }}" rel="stylesheet">
@endsection
@section('content')

@if (session('message'))
    <div class="alert alert-info">
        {{ session('message') }}
    </div>
@endif

<form method="POST" action="{{ route('unblockaccount', ['id' => Auth::user()->id]) }}">
    @csrf
    <h2>Unblock Account Request</h2>
    <p>If you believe your account has been blocked in error, please submit an appeal using the form below:</p>
    <p>Appeal:</p>
    <textarea placeholder="Enter Your Appeal content "id="appeal" name="appeal" rows="10" cols="30" required></textarea>
    <button class="button-submit"type="submit">
        Submit Unblock Request
    </button>
</form>

@endsection