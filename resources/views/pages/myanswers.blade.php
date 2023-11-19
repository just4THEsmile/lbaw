@extends('layouts.barebone')

@section('content')

    @php
        $user = Auth::user();
        $answers = $user->answers();
    @endphp
        @if($answers->isEmpty())
        <p>No questions found.</p>
        @else
        <ul>
        @foreach($answers as $answer)
        <li>Content: {{ $answer->content }}</li>
        @endforeach
        </ul>
    @endif

@endsection