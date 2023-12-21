@extends('layouts.app')

@section('style')
<link href="{{ asset('css/notification.css') }}" rel="stylesheet">
@endsection

@section('pagename')
Notifications
@endsection   
@section('content')

    <div class="sidebar">
    <a href="/home">Home Page</a>
    <a href="/feed">Feed</a>
    <a href="{{'/tags'}}">Tags</a>
    <a class="active" href="{{'/questions'}}">Questions</a>
    <a href="{{'/users'}}">Users</a>
    @if (Auth::check() && (Auth::user()->usertype == 'admin' || Auth::user()->usertype == 'moderator'))
            <a href="{{'/moderatecontent'}}">Blocked Content</a>
    @endif
    </div>
    <div class="container">
    @if ($errors->has('notifications'))
        <span class="error">
            {{ $errors->first('notifications') }}
        </span>
    @endif
    <form action="{{ route('deletenotifications')}}" method='post' >
        @csrf
        <button id="deleteNotifications" type='submit' class='edit' name="edit-button">Delete all Notifications</button>
    </form>

    <div class="row">
        <div class="col-lg-9 right">
            <div class="box shadow-sm rounded bg-white mb-3">
                <div class="box-title border-bottom p-3">
                    <h6 class="m-0">Recent</h6>
                </div>
                
                @foreach ($notifications as $notification)
                    @if ($notification->viewed)
                        @break
                    @endif
                    @if ($notification->type === 'Answer')
                        @include('partials.notification.answer', ['notification' => $notification])
                    @elseif ($notification->type === 'Comment')
                        @include('partials.notification.comment', ['notification' => $notification])
                    @elseif ($notification->type === 'Badge Attainment')
                        @include('partials.notification.badge', ['notification' => $notification])
                    @elseif ($notification->type === 'Vote')

                    @endif
                @endforeach
                <div class="box-body p-0">

                </div>
            </div>
            <div class="box shadow-sm rounded bg-white mb-3">
                <div class="box-title border-bottom p-3">
                    <h6 class="m-0">Earlier</h6>
                </div>
                @foreach ($notifications as $notification)
                    @if (! $notification->viewed)
                        @continue
                    @endif
                    @if ($notification->type == 'Answer')
                        @include('partials.notification.answer', ['notification' => $notification])
                    @elseif ($notification->type == 'Comment')
                        @include('partials.notification.comment', ['notification' => $notification])
                    @elseif ($notification->type == 'Badge Attainment')
                        @include('partials.notification.badge', ['notification' => $notification])
                    @elseif ($notification->type == 'Vote')

                    @endif
                @endforeach
            </div>
        </div>
    </div>
    {{ $PaginationController->links() }}
</div>
    
    <?php /*
    @include('partials.question', ['question' => $question])
    <div style="color:white; font-size:0.0001em;">Home</div>
    <section id="notifications">
        @each('partials.notification', $notifications, 'notification')

    </section> */?>
@endsection