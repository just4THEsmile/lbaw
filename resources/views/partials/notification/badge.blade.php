<div class="p-3 d-flex align-items-center bg-light border-bottom osahan-post-header">

    <div class="font-weight-bold mr-3">
        <div class="text-truncate">You just received a new badge "{{ $notification->badge_name }}"</div>

    </div>
    <span class="ml-auto mb-auto">
        <div class="btn-group">
            <form action="{{ route('deletenotification')}}" method='post' >
                @csrf
                <input type="hidden" name="notification_id" value="{{ $notification->notification_id }}">
                <button id="contentRequestsButton" type='submit' class="btn btn-light btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" name="delete-button">
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