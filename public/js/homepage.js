const Questions = document.getElementById("Questions");
const questionpagination = document.getElementById("QuestionPagination")
const questionsPerPage = 5;
let results = [];

function updateQuestions(){

        // Perform an AJAX request to your Laravel backend
        let currentPage = 1;
        fetch(`/api/myquestions/${user_id.textContent}`)
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
    updateQuestions();
}   

function showPage(currentPage){
    Questions.innerHTML = "";
    if(results.length == 0){
        Questions.innerHTML = "No questions Found";
    }
    for (let i = (currentPage - 1)*questionsPerPage; i < results.length && i<currentPage*questionsPerPage ; i++) {
        let result = results[i];
        // Create the main answer card div
        const questionCard = document.createElement("div");
        questionCard.classList.add("questioncard");

        // Create the link for the question title
        const titleLink = document.createElement("a");
        titleLink.href = `/question/${result.id}`;
        titleLink.textContent = result.title;
        titleLink.classList.add("title");
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
/*
        const votes = document.createElement("p");
        votes.textContent = result.votes;
        votes.classList.add("votes");
        // Append elements to the content div
        contentDiv.appendChild(votes);*/
        contentDiv.appendChild(contentParagraph);
        contentDiv.appendChild(dateParagraph);  

        // Append elements to the answer card div
        questionCard.appendChild(titleLink);
        questionCard.appendChild(contentDiv);

        // Append the answer card to the search results
        Questions.appendChild(questionCard);
        
    }
    renderPaginationButtons(currentPage);
}
function renderPaginationButtons(currentPage) {
    const totalPages = Math.ceil(results.length / questionsPerPage );
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

