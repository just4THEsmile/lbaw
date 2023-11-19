@extends('layouts.app')

@section('content')
    <section id="answers">
        @include('partials.question', ['question' => $question])
    </section>
@endsection