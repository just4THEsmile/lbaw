<div class="p-3 d-flex align-items-center bg-light border-bottom osahan-post-header">
    <div class="dropdown-list-image mr-3">
        <img class="rounded-circle" src="{{asset('profile/' . $notification->answer_user_picture)}}" alt="" />
    </div>
    <div class="font-weight-bold mr-3">
        <div class="text-truncate">Someone answered one of your question</div>
        <div class="small">{{ $notification->answer_username}} answer to "{{ $notification->title }}" with "{{ $notification->answer_content }}"</div>
        <a href="{{ route('question_show', $notification->question_id) }}" class="btn btn-outline-success btn-sm">View Question</a>
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
            
                <i class="mdi mdi-dots-vertical"></i>
        </div>
        <br />
        <div class="text-right text-muted pt-1">{{ $notification->notification_date }}</div>
    </span>
</div>