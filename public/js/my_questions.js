const searchOrderedBy_Selector = document.getElementById("sortSelect");


document.addEventListener("DOMContentLoaded", function () {
    searchOrderedBy_Selector.addEventListener("change", function () {
        updateQuestions();
    });
});
function updateQuestions(){

        // Perform an AJAX request to your Laravel backend
        fetch(`/api/myquestions/${user_id.textContent}?OrderBy=${searchOrderedBy_Selector.value}`)
            .then(response => response.json())
            .then(data => {
                // Update the search results in the DOM
                showPage(data.data,data.links);
                console.log(data);
            })
            .catch(error => {
                console.error('Error fetching search results', error);
            });

}
window.onload = function () {
    updateQuestions();
}   

function showPage(results,links){
    const Questions = document.getElementById("Questions");
    Questions.innerHTML = "";
    if(results.length == 0){
        Questions.innerHTML = "No questions Found";
    }
    for (let i = 0; i < results.length; i++) {
        if(tagsArray[i] == null) continue;
        let result = results[i];
        // Create the main answer card div
        const questionCard = document.createElement("div");
        questionCard.classList.add("question");

        //votes
        const votes = document.createElement("div");
        votes.classList.add("votes");
        const upvote = document.createElement("button");
        upvote.classList.add("arrow-up");

        // Create the <span> element with the class "material-symbols-outlined" and text content "expand_less"
        const upvoteSpan = document.createElement("span");
        upvoteSpan.classList.add("material-symbols-outlined");
        upvoteSpan.textContent = "expand_less";

        upvote.appendChild(upvoteSpan);

        // Create the <p> element with the class "votesnum" and set its content dynamically using data from the server
        const votesNum = document.createElement("p");
        votesNum.classList.add("votesnum");
        votesNum.textContent = result.votes; // Replace with actual data

        // Create the <button> element for downvote with the class "arrow-down"
        const downvote = document.createElement("button");
        downvote.classList.add("arrow-down");

        // Create the <span> element with the class "material-symbols-outlined" and text content "expand_more"
        const downvoteSpan = document.createElement("span");
        downvoteSpan.classList.add("material-symbols-outlined");
        downvoteSpan.textContent = "expand_more";

        // Append the <span> element to the downvote button
        downvote.appendChild(downvoteSpan);

        // Append the created elements to the <div> element
        votes.appendChild(upvote);
        votes.appendChild(votesNum);
        votes.appendChild(downvote);



        // Content
        const contentDiv = document.createElement("div");
        contentDiv.classList.add("content");

        // Create a paragraph for the question content
        const contentParagraph = document.createElement("p");
        contentParagraph.textContent = result.content; // Adjust based on your actual result structure
        
        // Create a paragraph for the date
        const dateParagraph = document.createElement("p");
        dateParagraph.textContent = result.date; // Adjust based on your actual result structure
        dateParagraph.classList.add("date");
        // Append elements to the content div
        contentDiv.appendChild(votes);
        contentDiv.appendChild(contentParagraph);
        contentDiv.appendChild(dateParagraph);  

        questionCard.appendChild(votes);
        questionCard.appendChild(contentDiv);
        questionCard.appendChild(votes);
        // Append the answer card to the search results
        Questions.appendChild(questionCard);
        
    }
    renderPaginationButtons(links);
}

