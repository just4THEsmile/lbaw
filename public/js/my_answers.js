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
        .then(response => response.json())
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

        const votes = document.createElement("p");
        votes.textContent = result.votes;
        votes.classList.add("votes");
        
        // Append elements to the content div
        contentDiv.appendChild(votes);
        contentDiv.appendChild(titleLink);
        contentDiv.appendChild(contentParagraph);
        contentDiv.appendChild(dateParagraph);  

        // Append elements to the answer card div
        answerCard.appendChild(contentDiv);

        // Append the answer card to the search results
        Answers.appendChild(answerCard);
        
    }
    renderPaginationButtons(links);
}
