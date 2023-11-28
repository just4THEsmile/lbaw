
<div class='edit-comment'>
    <form id='deletecomment' action="{{ route('delete_comment',['id' => $comment->commentable_id,'comment_id' => $comment->id ]) }}" method='post'>
        @csrf
        <button type='submit' class='delete' name="delete-button">delete</button>
    </form>


    <form id='editcomment' action="{{ route('delete_comment',['id' => $comment->commentable_id,'comment_id' => $comment->id ]) }}" method='GET'>
        <button type='submit' class='edit' name="edit-button">edit</button>
    </form>

    <form  class='report' action="{{route('report',['content_id'=> $comment->id])}}" method='post'>
        @csrf
        @if ($comment->content->isReported(auth()->user()))
            <button type='submit' class='unreportButton' name="unreport-button">Unreport</button>
        @else
            <button type='submit' class='reportButton' name="report-button">Report</button>
        @endif
    </form>
</div> 
