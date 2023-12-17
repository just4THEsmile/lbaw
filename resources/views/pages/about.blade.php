@extends('layouts.app')

@section ('style')
    <link href="{{ url('css/about.css') }}" rel="stylesheet">
@endsection

@section ('content')
<div class="sidebar">
    <a href="/home">Home Page</a>
    <a href="/feed">Feed</a>
    <a href="{{'/tags'}}">Tags</a>
    <a href="{{'/questions'}}">Questions</a>
    <a href="{{'/users'}}">Users</a>
</div>
<div class="about-container">
    <div class="about-section">
        <h1>About Our Web App</h1>
        <p>Our web application is a Collaborative Q&A platform designed to foster knowledge sharing and community building. We believe in the power of collective intelligence and aim to create a space where users can ask questions, share their expertise, and learn from each other.</p>
        
        <p>Our primary objective is to create a reliable and comprehensive knowledge base, built by users and for users. We strive to make information accessible and to promote a culture of continuous learning and curiosity. Whether you're looking for answers to technical questions, seeking advice on a particular topic, or willing to share your own insights, our platform is the place for you.</p>
        
        <p>We are committed to maintaining a respectful and inclusive environment. We believe that diversity of thoughts and experiences enriches our platform and leads to more comprehensive and creative solutions. We invite everyone to join us in our mission to share knowledge and learn from each other.</p>
      </div>
      
      <h2 >Our Team</h2>
      <div class="row">
        <div class="column">
          <div class="card">
            <img src="{{ asset('images/transferir.png') }}" alt="Diogo">
            <div class="container">
              <h2>Diogo Sarmento</h2>
              <p class="title">Project Developer</p>
              <p>Não sei</p>
              <p>diogosarmento@example.com</p>
            </div>
          </div>
        </div>
      
        <div class="column">
          <div class="card">
            <img src="{{ asset('images/transferir.png') }}" alt="Rodrigo">
            <div class="container">
              <h2>Rodrigo Póvoa</h2>
              <p class="title">Project Developer</p>
              <p>Fixe</p>
              <p>rodrigopovoa@example.com</p>
            </div>
          </div>
        </div>

        <div class="column">
            <div class="card">
              <img src="{{ asset('images/transferir.png') }}" alt="Tomas">
              <div class="container">
                <h2>Tomás Sarmento</h2>
                <p class="title">Project Developer</p>
                <p>setenta</p>
                <p>tomassarmento@example.com</p>
              </div>
            </div>
          </div>

      </div>

      
</div>

@endsection