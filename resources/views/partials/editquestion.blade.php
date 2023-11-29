
<div class='right-card'>
    <form id='passwordform' action="{{ $question->id }}/delete" method='post' onsubmit="disableSubmitButton()">
        @csrf
        <button type='submit' class='delete' name="delete-button">delete</button>
    </form>
</div> 
<form class="new_item" action="{{ $question->id }}/edit" method='get' >
    @csrf
    <button type='submit' class='edit' name="edit-button">Edit</button>
</form>

