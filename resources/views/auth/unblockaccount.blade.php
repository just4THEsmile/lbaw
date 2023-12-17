@extends('layouts.app')
@section ('style')
  <link href="{{ url('css/auth.css') }}" rel="stylesheet">
@endsection
@section('content')


<form method="POST" action="{{ route('unblockaccount', ['id' => Auth::user()->id]) }}">
    @csrf
    <h2>Unblock Account Request</h2>
    <p>If you believe your account has been blocked in error, please submit an appeal using the form below:</p>
    <p>Appeal:</p>
    <textarea id="appeal" name="appeal" rows="10" cols="30" required></textarea>
    <button class="button-submit"type="submit">
        Submit Unblock Request
    </button>
</form>

@endsection