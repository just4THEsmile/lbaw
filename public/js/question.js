
const errorDiv = document.getElementById('error');
const questionid = document.querySelector(`header > .votes > .arrow-up`).getAttribute('data-id');

const correct = document.getElementsByClassName("correctanswerButton");

document.addEventListener("DOMContentLoaded", function () {



    for (let i = 0; i < correct.length; i++) {

        correct[i].addEventListener("click", function () {
            sendAjaxRequest('post', '/api/correct/'+questionid,{ 'answerid' :correct[i].getAttribute('data-id')}, correctHandler);
        });
    }

    const votesup = document.getElementsByClassName("arrow-up");
    const votesdown = document.getElementsByClassName("arrow-down");
    //updatevoteStates();
    for (let i = 0; i < votesup.length; i++) {
        votesup[i].addEventListener("click", function () {
            upvote(votesup[i].getAttribute('data-id'));
        });
    }
    for (let i = 0; i < votesdown.length; i++) {
        votesdown[i].addEventListener("click", function () {
            downvote(votesdown[i].getAttribute('data-id'));
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
    let element = document.querySelector(`[data-id='${id}'].arrow-down`);
    let element2 = document.querySelector(`[data-id='${id}'].arrow-up`);
    if(vote.message == "down"){
        element2.classList.remove("voted");
        element.classList.add("voted");
        element.previousElementSibling.textContent = vote.votes;
    }else{
        
        element.classList.remove("voted");
        element.previousElementSibling.textContent = vote.votes;
    }  

    errorDiv.innerHTML='';
}

function upvoteHandler() {
    if (this.status != 200) {
        let error = JSON.parse(this.responseText);
        errorDiv.textContent = error.message;
        return;
    }
    let vote = JSON.parse(this.responseText);
    let id = vote.id;
    let element = document.querySelector(`[data-id='${id}'].arrow-up`);
    let element2 = document.querySelector(`[data-id='${id}'].arrow-down`);
    if(vote.message == "up"){
        element2.classList.remove("voted");
        element.classList.add("voted");
        element.nextElementSibling.textContent = vote.votes;
    }else{
        element.classList.remove("voted");
        element.nextElementSibling.textContent = vote.votes;
    }  

    errorDiv.innerHTML='';
}

function correctHandler() {

    if (this.status != 200) {
        let error = JSON.parse(this.responseText);
        errorDiv.textContent = error.message;
        return;
    }
    let answer = JSON.parse(this.responseText);
    console.log(answer);
    let id = answer.answerid;
    console.log(id);
    let oldcorrect= document.getElementsByClassName(`correct`)
    console.log(oldcorrect);
    if(answer.message == 'removed correct answer'){
        for(let i = 0; i < oldcorrect.length; i++){
            if(oldcorrect[i].getAttribute('data-id') == id){
                oldcorrect[i].innerHTML = '';
            }
        }
        return;
    }

    for(let i = 0; i < oldcorrect.length; i++){
        if(oldcorrect[i].getAttribute('data-id') == id){
            oldcorrect[i].innerHTML = '<span class="material-symbols-outlined">check</span>';
        }else{
            oldcorrect[i].innerHTML = '';
        }
    }
    errorDiv.innerHTML='';
    return;

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