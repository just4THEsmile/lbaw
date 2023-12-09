<div class="p-3 d-flex align-items-center bg-light border-bottom osahan-post-header">

    <div class="font-weight-bold mr-3">
        <div class="text-truncate">You just received a new badge "{{ $notification->badge_name }}"</div>

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