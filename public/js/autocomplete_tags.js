const hashtagInput = document.getElementById('TagsInput');
var autocomplete = document.getElementById('autocomplete');

const questionId = document.getElementById('questionid').value;
// const stopshowingtagsbutton = document.getElementById('stopShowingTags');
var hashtags = [];
window.onload = async function () {
  console.log(1);
  const response = await fetch('/../question/'+ encodeURIComponent(questionId) + '/tags' );
  hashtags = await response.json();
  console.log(hashtags);
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
  for (let i = 0; i < hashtags.length; i++) {
    const hashtag = hashtags[i];
    const hashtagSpan = document.createElement('span');
    hashtagSpan.classList = 'hashtag';
    hashtagSpan.textContent = hashtag.name;
    const removeIcon = document.createElement('span');
    removeIcon.classList = 'remove-icon';
    removeIcon.textContent = 'x';
    removeIcon.addEventListener('click', () => {
      hashtags.splice(i, 1);
      refreshHashtags();
    });
    hashtagSpan.appendChild(removeIcon);
    document.getElementById('hashtags').appendChild(hashtagSpan);
  }
}
function submitHandler() {
  if (this.status != 200){
    let error = JSON.parse(this.responseText);
    let errorDiv = document.getElementById('error');
    errorDiv.textContent = error.message;
  } else{
    window.location = '/question/' + questionId;
  }
}
function submitAction(){
  let title = document.forms["formEdit"]["title"].value;
  let description = document.forms["formEdit"]["description"].value;
  if(title == '' || description == ''){

  }else{
    sendAjaxRequest('post', '/createquestion', {'title':title , 'description':description , 'tags':hashtags}, 'submitHandler');
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

function encodeForAjax(data) {
  if (data == null) return null;
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&');
}

function sendAjaxRequest(method, url, data, handler) {
  let request = new XMLHttpRequest();

  request.open(method, url, true);
  request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  request.addEventListener('load', handler);
  request.send(encodeForAjax(data));
}

async function activateAutocomplete() {
    // Fetch list of hashtags from server
    const response = await fetch('/search/tag?query='+ encodeURIComponent(hashtagInput.value) + '&questionid=' + encodeURIComponent(questionId));
    const hashtags = await response.json();
    console.log(hashtags);
    // Display autocomplete suggestions
    autocomplete.innerHTML = '';
    hashtags.forEach((tag) => {
      const option = document.createElement('div');
      option.classList = 'autocomplete-option'
      option.textContent = tag.title;
      option.addEventListener('click', () => {
        //addHashtag(tag);
        hashtags.push({'id': tag.id, 'name': tag.name});
        refreshHashtags();
        autocomplete.innerHTML = '';
        hashtagInput.value = '';
      });
      autocomplete.appendChild(option);
    });
  
}
var NewTag = document.getElementById("NewTag");
var Tag = document.getElementById("AddTag");

NewTag.addEventListener("click", function() {
  if (Tag.style.display === "none") {
    Tag.style.display = "block";
    NewTag.textContent= "-"
  } else {
    Tag.style.display = "none";
    NewTag.textContent= "+"
  }
});