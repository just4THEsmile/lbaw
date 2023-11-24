
<div class='edit-comment'>
    <form id='deletecomment' action="{{ route('delete_comment',['id' => $comment->commentable_id,'comment_id' => $comment->id ]) }}" method='post'>
        @csrf
        <button type='submit' class='delete' name="delete-button">&#10761;</button>
    </form>
    <a href="{{ route('edit_comment_form',['id' => $comment->commentable_id,'comment_id' => $comment->id ]) }}" class='edit'>&#9998;</a>

    <form  class='report' action="{{route('report',['content_id'=> $comment->id])}}" method='post'>
        @csrf
        @if ($comment->content->isReported(auth()->user()))
            <button type='submit' class='unreportButton' name="unreport-button">Unreport Comment</button>
        @else
            <button type='submit' class='reportButton' name="report-button">Report Comment</button>
        @endif
    </form>
</div> 
