
<div class='edit-comment'>
    <form id='deletecomment' action="{{ route('delete_comment',['id' => $comment->commentable_id,'comment_id' => $comment->id ]) }}" method='post' onsubmit="disableSubmitButton()">
        @csrf
        <button type='submit' class='delete' name="delete-button">
            <span class="material-symbols-outlined">
                delete
            </span>
        </button>
    </form>


    <form id='editcomment' action="{{ route('edit_comment_form',['id' => $comment->commentable_id,'comment_id' => $comment->id ]) }}" method='get' onsubmit="disableSubmitButton()">
        @csrf
        <button type='submit' class='edit' name="edit-button">
        <span class="material-symbols-outlined">
            edit
        </span>            
        </button>
    </form>

    <form  class='report' action="{{route('report',['content_id'=> $comment->id])}}" method='post' onsubmit="disableSubmitButton()">
        @csrf
        @if ($comment->content->isReported(auth()->user()))
            <button type='submit' class='unreportButton' name="unreport-button">Unreport</button>
        @else
            <button type='submit' class='reportButton' name="report-button">Report</button>
        @endif
    </form>
</div> 
