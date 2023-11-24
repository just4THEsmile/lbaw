
<div class='edit-answer'>
    <form id='deletequestion' action="{{ $answer->question_id }}/answer/{{ $answer->id }}/delete" method='post'>
        @csrf
        <button type='submit' class='delete' name="delete-button">&#10761;</button>
    </form>
    <form class="editquestion" action="{{ $answer->question_id }}/answer/{{ $answer->id }}/edit" method='get'>
        @csrf
        <button type='submit' class='edit' name="edit-button">Edit</button>
    </form>
    
</div> 


