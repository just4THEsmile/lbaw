<div class="p-3 d-flex align-items-center bg-light border-bottom osahan-post-header">
    <div class="dropdown-list-image mr-3">
        <img class="rounded-circle" src="{{asset('profile/' . $notification->comment_user_profile_pick)}}"  alt="" />
    </div>
    <div class="font-weight-bold mr-3">
        <div class="text-truncate">{{ $notification->comment_username}} commented your content</div>
        <div class="small">{{ $notification->comment_username}} with "{{ $notification->comment_content }}".</div>
    </div>
    <span class="ml-auto mb-auto">
        <div class="btn-group">
            <button type="button" class="btn btn-light btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="mdi mdi-dots-vertical"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <button class="dropdown-item" type="button"><i class="mdi mdi-delete"></i> Delete</button>
                <button class="dropdown-item" type="button"><i class="mdi mdi-close"></i> Turn Off</button>
            </div>
        </div>
        <br />
        <div class="text-right text-muted pt-1">{{ $notification->notification_date }}</div>
    </span>
</div>