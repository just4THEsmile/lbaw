@extends('layouts.app')

@section ('style')
    <link href="{{ url('css/about.css') }}" rel="stylesheet">
@endsection

@section('og')
    <meta property="og:title" content="About Us" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url('/about') }}" />
    <meta property="og:description" content="About Us" />
    <meta property="og:image" content="{{ asset('images/icon.png') }}" />
@endsection

@section ('content')
<div class="sidebar">
    <a href="/home">Home Page</a>
    <a href="/feed">Feed</a>
    <a href="{{'/tags'}}">Tags</a>
    <a href="{{'/questions'}}">Questions</a>
    <a href="{{'/users'}}">Users</a>
    @if (Auth::check() && (Auth::user()->usertype == 'admin' || Auth::user()->usertype == 'moderator'))
        <a href="{{'/moderatecontent'}}">Blocked Content</a>
    @endif
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
              <p class="title" style="font-weight:bold; margin-bottom:0.5em;">Project Developer</p>
              <p>diogosarmento@example.com</p>
              <p>Hello! I'm Diogo, a dedicated web developer with a passion for creating seamless and delightful user experiences. My journey in web development revolves around understanding user needs and translating them into intuitive interfaces. Specializing in front-end development and UX design, I believe in the power of user-centric design to elevate digital experiences. From responsive layouts to interactive features, my goal is to make the web a more user-friendly and accessible space. Let's collaborate on projects that prioritize both functionality and a fantastic user journey.</p>
              
            </div>
          </div>
        </div>
      
        <div class="column">
          <div class="card">
            <img src="{{ asset('images/transferir.png') }}" alt="Rodrigo">
            <div class="container">
              <h2>Rodrigo Póvoa</h2>
              <p class="title" style="font-weight:bold; margin-bottom:0.5em;">Project Developer</p>
              <p>rodrigopovoa@example.com</p>
              <p> Hi there! I'm Rodrigo, a passionate web developer with a flair for creativity and a knack for turning ideas into interactive digital experiences. My journey in web development started with a love for design, and I've since honed my skills in front-end development to bring visually stunning and user-friendly websites to life. Whether it's crafting responsive layouts, experimenting with cutting-edge technologies, or optimizing for performance, I thrive on pushing the boundaries of what's possible on the web. Let's collaborate and bring your vision to the digital world!</p>
              
            </div>
          </div>
        </div>

        <div class="column">
            <div class="card">
              <img src="{{ asset('images/transferir.png') }}" alt="Tomás">
              <div class="container">
                <h2>Tomás Sarmento</h2>
                <p class="title" style="font-weight:bold; margin-bottom:0.5em;">Project Developer</p>
                <p>tomassarmento@example.com</p>
                <p>Greetings! I'm Tomás, a results-driven web developer with a focus on solving real-world problems through efficient and robust solutions. With a background in full-stack development, I navigate seamlessly between the front and back ends, ensuring that every component of a web application works harmoniously. I thrive on tackling complex challenges, optimizing code for performance, and implementing scalable architectures. Let's work together to build web solutions that not only meet but exceed expectations.</p>
                
              </div>
            </div>
          </div>

      </div>

    <h2>Contact Us Directly</h2>
    <div class="contacts" style="padding:1em;box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <p>By Email:  qthena@example.com</p>
        <p style="margin-bottom:0em">By Phone: +351 123 456 789</p>
    </div>
</div>

@endsection