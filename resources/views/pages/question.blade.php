@extends('layouts.app')

@section('title', $question->title)

@section('content')
    <section id="answers">
        @include('partials.question', ['question' => $question])
    </section>
@endsection