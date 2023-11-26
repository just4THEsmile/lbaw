const searchInput = document.getElementById("searchInput");
const searchResults = document.getElementById("searchResults");
const searchOrderedBy_Selector = document.getElementById("sortSelect");
const questionpagination = document.getElementById("QuestionPagination")
const questionsPerPage = 5;
let results = [];
document.addEventListener("DOMContentLoaded", function () {

    searchInput.addEventListener("input", function () {
        searchQuestions();
    });
    searchOrderedBy_Selector.addEventListener("change", function () {
        searchQuestions();
    });
});
function searchQuestions(){
    const query = searchInput.value;

    // Perform an AJAX request to your Laravel backend
    let currentPage = 1;
    fetch(`/search/questions?OrderBy=${searchOrderedBy_Selector.value}&q=${query}`)
        .then(response => response.json())
        .then(data => {
            // Update the search results in the DOM
            results = data;
            showPage(currentPage);
            renderPaginationButtons(currentPage);
        })
        .catch(error => {
            console.error('Error fetching search results', error);
        });

}
window.onload = function () {
    searchQuestions();
}   

function showPage(currentPage){
    searchResults.innerHTML = "";
    for (let i = (currentPage - 1)*questionsPerPage; i < results.length && i<currentPage*questionsPerPage ; i++) {
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

        const questionLink = document.createElement("a");
        questionLink.href = `/question/${result.id}`; // Replace with actual URL

        const questionTitle = document.createElement("h3");
        questionTitle.textContent = result.title; // Replace with actual title

        questionLink.appendChild(questionTitle);

        const profileInfoDiv = document.createElement("div");
        profileInfoDiv.classList.add("profileinfo");

        const userProfileLink = document.createElement("a");
        userProfileLink.href = `/profile/${result.userid}`; // Replace with actual URL
        userProfileLink.textContent = result.username; // Replace with actual username

        const questionDate = document.createElement("p");
        questionDate.textContent = result.date; // Replace with actual date

        
        console.log(result);  

        contentDiv.appendChild(questionLink);
        profileInfoDiv.appendChild(userProfileLink);
        profileInfoDiv.appendChild(questionDate);
        contentDiv.appendChild(profileInfoDiv);

        questionCard.appendChild(votes);
        questionCard.appendChild(contentDiv);

        // Append the answer card to the search results
        searchResults.appendChild(questionCard);
        
    }
    renderPaginationButtons(currentPage);
}
function renderPaginationButtons(currentPage) {
    const totalPages = Math.ceil(results.length / questionsPerPage );
    const paginationContainer = document.getElementById("QuestionPagination")
    paginationContainer.innerHTML = "";
    let delta = currentPage + 3;
    if (delta > totalPages) delta = totalPages;
    let start = currentPage - 3;
    if (currentPage <= 3) start =1;
    for (let i = start; i <=delta; i++) {
        const button = document.createElement("button");
        button.textContent = i;
        button.classList.add("pagination-button");
        // Highlight the current page
        if (i === currentPage) {
            button.style.backgroundColor = "#4CAF50";
        }

        button.addEventListener("click", function () {
            currentPage = i;
            showPage(currentPage);
            
        });

        paginationContainer.appendChild(button);
    }
}

