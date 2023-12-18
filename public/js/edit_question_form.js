const hashtagInput = document.getElementById('TagsInput');
var autocomplete = document.getElementById('autocomplete');
const errorDiv = document.getElementById('questionerror');
const questionId = document.getElementById('questionid').value;
// const stopshowingtagsbutton = document.getElementById('stopShowingTags');
var hashtags = [];
window.onload = async function () {
  const response = await fetch('/../question/'+ encodeURIComponent(questionId) + '/tags' );
  hashtags = await response.json();
  refreshHashtags();
}   
// Listen for hashtag input
hashtagInput.addEventListener('keyup', async (event) => {
  activateAutocomplete();
});

// Listen for click on hashtag input
hashtagInput.addEventListener('click', async (event) => {
  activateAutocomplete();
});
function refreshHashtags() {
  document.getElementById('selectedtags').innerHTML = '';
  for (let i = 0; i < hashtags.length; i++) {
    const hashtag = hashtags[i];
    const hashtagSpan = document.createElement('span');
    hashtagSpan.classList = 'hashtag';
    hashtagSpan.textContent = hashtag.title;
    const removeIcon = document.createElement('span');
    removeIcon.classList = 'material-symbols-outlined';
    removeIcon.textContent = 'close';

    removeIcon.addEventListener('click', () => {
      hashtags.splice(i, 1);
      refreshHashtags();
    });
    hashtagSpan.appendChild(removeIcon);
    document.getElementById('selectedtags').appendChild(hashtagSpan);
  }
}
function submitHandler() {
  if (this.status != 200){
    const errorTitle = document.getElementById('titleError');
    const errorContent = document.getElementById('contentError');
    const errorTags = document.getElementById('errorAddTag');
    errorTitle.textContent = '';
    errorContent.textContent = '';
    errorTags.textContent = '';
    const error = JSON.parse(this.responseText);
    const messages = error.messages;
    if(messages.title){
      errorTitle.textContent = messages.title;
    }
    if(messages.content){
      errorContent.textContent = messages.content;
    }
    if(messages.tags){
      errorTags.textContent = messages.tags;
    }
    if(messages.message){
      errorDiv.textContent = messages.message;
    }
  } else{
    window.location = '/question/' + questionId;
  }
}
const button = document.getElementById('submitbutton');
button.addEventListener('click', function(event) { //Close Autocomplete
  submitAction();
});

function submitAction(){
  title = document.getElementById('title').value;
  description = document.getElementById('questionContent').value;
    let TagIds = [];
    for(let i = 0; i < hashtags.length; i++){
      TagIds.push(hashtags[i].id);
    }
    sendAjaxRequest('post', '/question/'+questionId+'/edit', {'title':title , 'content':description , 'tags':TagIds}, submitHandler);
}
// stopshowingtagsbutton.addEventListener('click', async (event) => {
// stopshowingtagsbutton.style.display = "none";
// autocomplete.innerHTML = '';
// hashtagInput.value = '';
// });
document.addEventListener('click', function(event) { //Close Autocomplete
  // Check if click target is the hashtag input
  if (event.target.closest('#hashtags') !== null) {
    return; // Don't close the autocomplete
  }
  //  close the autocomplete
  autocomplete.innerHTML = '';
});

async function activateAutocomplete() {
    // Fetch list of hashtags from server
    const response = await fetch('/search/tag?query='+ encodeURIComponent(hashtagInput.value));
    const autocompletetags = await response.json();
    // Display autocomplete suggestions
    autocomplete.innerHTML = '';
    let count = 0;
    let errorAddTag = document.getElementById('errorAddTag');
    autocompletetags.forEach((tag) => {
      if(count == 5){
        return;
      }
      for(let i = 0; i < hashtags.length; i++){
        if(hashtags[i].id == tag.id ){
          return;
        }
      }
      count++;
      const option = document.createElement('div');
      option.classList = 'autocomplete-option'
      option.textContent = tag.title;
      option.addEventListener('click', () => {
        if(hashtags.length >= 5){
          errorAddTag.textContent = "You can only add 5 tags";
          return;
        }else{
          hashtags.push({'id': tag.id, 'title': tag.title});
          refreshHashtags();
          autocomplete.innerHTML = '';
          hashtagInput.value = '';
        }
      });
      autocomplete.appendChild(option);
    });
  
}
