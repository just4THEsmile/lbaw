
const errorDiv = document.getElementById('error');
const questionid = document.querySelector(`header > .votes > .arrow-up`).id;

document.addEventListener("DOMContentLoaded", function () {

    const correct = document.getElementsByClassName("correctbutton");

    for (let i = 0; i < correct.length; i++) {
        correct[i].addEventListener("click", function () {
            sendAjaxRequest('post', '/api/correct/'+questionid,{ 'answerid' :correct[i].id}, correctHandler);
        });
    }

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

    sendAjaxRequest('post', '/api/vote/'+id, {'value': "down"}, downvoteHandler);

}

function upvote(id) {

    sendAjaxRequest('post', '/api/vote/'+id, {'value': "up"}, upvoteHandler);

}
function downvoteHandler() {
    if (this.status != 200) {
        let error = JSON.parse(this.responseText);
        errorDiv.textContent = error.message;
        return;
    }
    let vote = JSON.parse(this.responseText);
    let id = vote.id;
    let element = document.querySelector(`[id='${id}'].arrow-down`);
    let element2 = document.querySelector(`[id='${id}'].arrow-up`);
    if(vote.message == "down"){
        element2.classList.remove("voted");
        element.classList.add("voted");
        element.previousElementSibling.textContent = vote.votes;
    }else{
        
        element.classList.remove("voted");
        element.previousElementSibling.textContent = vote.votes;
    }  

    console.log(vote);
}

function upvoteHandler() {
    if (this.status != 200) {
        let error = JSON.parse(this.responseText);
        errorDiv.textContent = error.message;
        return;
    }
    let vote = JSON.parse(this.responseText);
    let id = vote.id;
    let element = document.querySelector(`[id='${id}'].arrow-up`);
    let element2 = document.querySelector(`[id='${id}'].arrow-down`);
    if(vote.message == "up"){
        element2.classList.remove("voted");
        element.classList.add("voted");
        element.nextElementSibling.textContent = vote.votes;
    }else{
        element.classList.remove("voted");
        element.nextElementSibling.textContent = vote.votes;
    }  

    console.log(vote);
}

function correctHandler() {

}

function sendAjaxRequest(method, url, data, handler) {
    let request = new XMLHttpRequest();
    request.open(method, url, true);
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