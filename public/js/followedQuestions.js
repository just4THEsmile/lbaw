const searchOrderedBy_Selector = document.getElementById("sortSelect");


document.addEventListener("DOMContentLoaded", function () {
    searchOrderedBy_Selector.addEventListener("change", function () {
        updateQuestions();
    });
});

function updateQuestions(){

    // Perform an AJAX request to your Laravel backend
    let currentPage = 1;
    fetch(`/api/followedQuestions/${user_id.textContent}?OrderBy=${searchOrderedBy_Selector.value}`)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            showPage(data.data,data.links);   
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

        const votes = document.createElement("p");
        votes.textContent = result.votes;
        votes.classList.add("votes");
        // Append elements to the content div
        contentDiv.appendChild(votes);
        contentDiv.appendChild(contentParagraph);
        contentDiv.appendChild(dateParagraph);  

        // Append elements to the answer card div
        questionCard.appendChild(titleLink);
        questionCard.appendChild(contentDiv);

        // Append the answer card to the search results
        Questions.appendChild(questionCard);
        
    }
    renderPaginationButtons(links);
}

