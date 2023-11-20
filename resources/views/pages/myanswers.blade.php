<<<<<<< HEAD
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

=======
@extends('layouts.barebone')

@section('content2')


    <style>
        #MyAnswers{
            background-color: #0000FF;
            
        }
        #MyAnswers > a{
            color:white;
        } 
    </style>
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

>>>>>>> 724ec5d460922cb5fe6a8d6832400ebf2cf16e81
@endsection