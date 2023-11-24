
<div class='edit-answer'>
    <form id='deletequestion' action="{{ $answer->question_id }}/answer/{{ $answer->id }}/delete" method='post'>
        @csrf
        <button type='submit' class='delete' name="delete-button">&#10761;</button>
    </form>
    <form class="editquestion" action="{{ $answer->question_id }}/answer/{{ $answer->id }}/edit" method='get'>
        @csrf
        <button type='submit' class='edit' name="edit-button">Edit</button>
    </form>
    <form  class='report' action="{{route('report',['content_id'=> $answer->commentable->content->id])}}" method='post'>
        @csrf
        @if ($answer->commentable->content->isReported(auth()->user()))
            <button type='submit' class='unreportButton' name="unreport-button">Unreport Answer</button>
        @else
            <button type='submit' class='reportButton' name="report-button">Report Answer</button>
        @endif
    </form>
</div> 


