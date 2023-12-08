const hashtagInput = document.getElementById('TagsInput');
var autocomplete = document.getElementById('autocomplete');
const errorDiv = document.getElementById('error');
// const stopshowingtagsbutton = document.getElementById('stopShowingTags');
var hashtags = [];
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
    let error = JSON.parse(this.responseText);
    errorDiv.textContent = error.message;
  } else{
    window.location = '/question/'+ this.responseText ;
  }
}
const button = document.getElementById('submitbutton');
button.addEventListener('click', function(event) { //Close Autocomplete
  submitAction();
});

function submitAction(){
  title = document.getElementById('title').value;
  errorTitle = document.getElementById('titleError');
  errorContent = document.getElementById('contentError');
  description = document.getElementById('questionContent').value;
  if(title == ''){
    errorTitle.textContent = 'title cant be empty';
  }else if(title.length > 70){
    errorTitle.textContent = 'title cant be longer than 70 characters';
  }else if(description == ''){
    errorContent.textContent = 'Content cant be empty';
  }else if(description.length > 300){
    errorContent.textContent = 'Content cant be shorter than 300 characters';
  }else{
    let TagIds = [];
    for(let i = 0; i < hashtags.length; i++){
      TagIds.push(hashtags[i].id);
    }
    sendAjaxRequest('post', '/createquestion', {'title':title , 'content':description , 'tags':TagIds}, submitHandler);
  }
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
    //console.log(hashtags);
    // Display autocomplete suggestions
    autocomplete.innerHTML = '';
    let count = 0;
    console.log(hashtags);
    let errorAddTag = document.getElementById('errorAddTag');
    autocompletetags.forEach((tag) => {
      if(count == 5){
        return;
      }
      for(let i = 0; i < hashtags.length; i++){
        if(hashtags[i].id == tag.id ){
          console.log(count);
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