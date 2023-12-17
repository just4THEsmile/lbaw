const searchOrderedBy_Selector = document.getElementById("sortSelect");


document.addEventListener("DOMContentLoaded", function () {
    searchOrderedBy_Selector.addEventListener("change", function () {
        updateAnswers();
    });
});

function updateAnswers(){
    const user_id = document.getElementById("user_id")
    console.log(searchOrderedBy_Selector.value)
    fetch(`/api/myanswers/${user_id.textContent}?OrderBy=${searchOrderedBy_Selector.value}`)
        .then(response => {
            if (response.status == 200) {
                return response.json();
            }else{
                error.textContent = "Error fetching awnswers";
            }
        })
        .then(data => {
            console.log(data.data);
            showPage(data.data,data.links);   
        })
        .catch(error => {
            console.error('Error fetching search results', error);
        });

}
window.onload = function () {
    updateAnswers();
}   

function showPage(results,links){
    const Answers = document.getElementById("Answers");
    Answers.innerHTML = "";
    if(results.length == 0){
        Answers.innerHTML = "No Answers Found";
    }
    for (let i = 0; i < results.length ; i++) {
        let result = results[i];
        console.log(result);
        var answerSpan = document.createElement("span");
        answerSpan.classList.add("answer");
        answerSpan.setAttribute("data-id", result.id); // Replace "123" with the actual answer ID
      
        // Create the answer content container
        var questiontitle = document.createElement("h3");
        var questionLink = document.createElement("a");
        questionLink.href = `/question/${result.questionid}`; // Replace with the actual question URL
        questionLink.textContent = result.tile; // Replace with the actual question title
        questiontitle.appendChild(questionLink);
        console.log(result.tile);

        var answerContentDiv = document.createElement("div");
        answerContentDiv.classList.add("answercontent");
      
        // Create the edited tag paragraph
        var editTagP = document.createElement("p");
        editTagP.classList.add("edittag");
        if(result.edited === true){
            editTagP.textContent = "edited";
        }else {  
            editTagP.textContent = "";
        }
        // Create the content span
        var contentSpan = document.createElement("span");
        contentSpan.textContent = result.content; // Replace with the actual answer content
      
        // Create the profile info container
        var profileInfoDiv = document.createElement("div");
        profileInfoDiv.classList.add("profileinfo");
      
        // Create the profile link
        var profileLink = document.createElement("a");
        profileLink.href = "http://example.com/profile/123"; // Replace with the actual profile URL
        profileLink.textContent = result.username; // Replace with the actual username
      
        // Create the timestamp paragraph
        var timestampP = document.createElement("p");
        timestampP.textContent = result.date; // Replace with the actual timestamp
      
        // Append elements to their respective containers
        profileInfoDiv.appendChild(profileLink);
        profileInfoDiv.appendChild(timestampP);
        
        answerContentDiv.appendChild(questiontitle);
        answerContentDiv.appendChild(editTagP);
        answerContentDiv.appendChild(contentSpan);
        answerContentDiv.appendChild(profileInfoDiv);
      
        answerSpan.appendChild(answerContentDiv);

        // Append the answer card to the search results
        Answers.appendChild(answerSpan);
        
    }
    renderPaginationButtons(links);
}
