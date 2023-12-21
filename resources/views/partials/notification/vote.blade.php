<div class="p-3 d-flex align-items-center bg-light border-bottom osahan-post-header">
    <div class="font-weight-bold mr-3">
        <div class="dropdown-list-image mr-3">
            <img class="rounded-circle" src="{{asset('profile/' . $notification->vote_user_profile_pick)}}"  alt="" />
        </div>
        @if($notification->vote == True)
            <div class="text-truncate">{{ $notification->vote_username}} liked your content</div>
        @else
            <div class="text-truncate">{{ $notification->vote_username}} disliked your content</div>
        @endif
    </div>
    <span class="ml-auto mb-auto">
        <div class="btn-group">
            <form action="{{ route('deletenotification')}}" method='post' >
                @csrf
                <input type="hidden" name="notification_id" value="{{ $notification->notification_id }}">
                <button type='submit' class="btn btn-light btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" name="delete-button">
                <span class="material-symbols-outlined">
                    delete
                </span>                    
                </button>
            </form>
        </div>
        <br />
        <div class="text-right text-muted pt-1">{{ $notification->notification_date }}</div>
    </span>
</div>