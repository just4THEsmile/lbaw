const Answers = document.getElementById("Answers");
const questionpagination = document.getElementById("AnswersPagination")
const user_id = document.getElementById("user_id")
const AnswersPerPage = 5;
let results = [];

function updateAnswers(){

    // Perform an AJAX request to your Laravel backend
    let currentPage = 1;
    fetch(`/api/myanswers/${user_id.textContent}`)
        .then(response => response.json())
        .then(data => {
            // Update the search results in the DOM
            results = data;
            showPage(currentPage);   
        })
        .catch(error => {
            console.error('Error fetching search results', error);
        });

}
window.onload = function () {
    updateAnswers();
}   

function showPage(currentPage){
    Answers.innerHTML = "";
    if(results.length == 0){
        Answers.innerHTML = "No Answers Found";
    }
    for (let i = (currentPage - 1)*AnswersPerPage; i < results.length && i<currentPage*AnswersPerPage ; i++) {
        let result = results[i];
        // Create the main answer card div
        const answerCard = document.createElement("div");
        answerCard.classList.add("answercard");

        // Create the content div
        const contentDiv = document.createElement("div");
        contentDiv.classList.add("content");

        // Create a paragraph for the question content
        const contentParagraph = document.createElement("p");
        contentParagraph.textContent = result.content; // Adjust based on your actual result structure

        // Create a paragraph for the date
        const dateParagraph = document.createElement("p");
        dateParagraph.textContent = result.date; // Adjust based on your actual result structure
        dateParagraph.classList.add("date");
        const titleLink = document.createElement("a");
        titleLink.href = `/question/${result.question_id}`;
        titleLink.textContent = result.title;
        titleLink.classList.add("title");
/*
        const votes = document.createElement("p");
        votes.textContent = result.votes;
        votes.classList.add("votes");
        
        // Append elements to the content div
        contentDiv.appendChild(votes);*/
        contentDiv.appendChild(titleLink);
        contentDiv.appendChild(contentParagraph);
        contentDiv.appendChild(dateParagraph);  

        // Append elements to the answer card div
        answerCard.appendChild(contentDiv);

        // Append the answer card to the search results
        Answers.appendChild(answerCard);
        
    }
    renderPaginationButtons(currentPage);
}
function renderPaginationButtons(currentPage) {
    const totalPages = Math.ceil(results.length / AnswersPerPage );
    questionpagination.innerHTML = "";
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

        questionpagination.appendChild(button);
    }
}
