



document.addEventListener("DOMContentLoaded", function () {
    const errorDiv = document.getElementById('error');
    const votesup = document.getElementsByClassName("arrow-up");
    const votesdown = document.getElementsByClassName("arrow-down");
    //updatevoteStates();
    for (let i = 0; i < votesup.length; i++) {
        votesup[i].addEventListener("click", function () {
            upvote(votesup[i].id);
        });
    }
    for (let i = 0; i < votesdown.length; i++) {
        votesdown[i].addEventListener("click", function () {
            downvote(votesup[i].id);
        });
    }
    
});

function downvote(id) { 

    sendAjaxRequest('post', '/api/vote/'+id, {'value': "down"}, upvoteHandler);

}

function upvote(id) {

    sendAjaxRequest('post', '/api/vote/'+id, {'value': "up"}, upvoteHandler);

}

function upvoteHandler() {
    if (this.status != 200) {
        console.log(this.responseText);
        return;
    }
    let response = JSON.parse(this.responseText);
    let vote = document.getElementById(response.id);
    let votevalue = vote.getElementsByClassName("votevalue")[0];
    votevalue.innerHTML = response.value;
    updatevoteStates();
}

function sendAjaxRequest(method, url, data, handler) {
    let request = new XMLHttpRequest();
    console.log(url);
    request.open(method, url, true);
    console.log(request);
    request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.addEventListener('load', handler);
    request.send(encodeForAjax(data));
  }

  function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
  }