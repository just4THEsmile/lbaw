const Tags = document.getElementById("Tags");
const Tagpagination = document.getElementById("TagsPagination")
const searchTagInput = document.getElementById("searchTagInput");
const TagsPerPage = 10;
let results = [];

document.addEventListener("DOMContentLoaded", function () {

    searchTagInput.addEventListener("input", function () {
        updateTags();
    });
});

function updateTags(){
    const query = searchTagInput.value;
    // Perform an AJAX request to your Laravel backend
    let currentPage = 1;
    fetch(`/api/fullsearch/tag?query=${query}`)
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
    updateTags();
}   

function showPage(currentPage){
    Tags.innerHTML = "";
    if(results.length == 0){
        Tags.innerHTML = "No Tags Found";
    }
    for (let i = (currentPage - 1)*TagsPerPage; i < results.length && i<currentPage*TagsPerPage ; i++) {
        let result = results[i];
        // Create the main Tag card div
        const TagCard = document.createElement("div");
        TagCard.classList.add("Tagcard");

        // Create the content div
        const contentDiv = document.createElement("div");
        contentDiv.classList.add("content");

        // Create a paragraph for the Tag content
        const contentParagraph = document.createElement("p");
        contentParagraph.textContent = result.description; // Adjust based on your actual result structure
        const titleLink = document.createElement("a");
        titleLink.href = `/Tag/${result.Tag_id}`;
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

        // Append elements to the Tag card div
        TagCard.appendChild(contentDiv);

        // Append the Tag card to the search results
        Tags.appendChild(TagCard);
        
    }
    renderPaginationButtons(currentPage);
}
function renderPaginationButtons(currentPage) {
    const totalPages = Math.ceil(results.length / TagsPerPage );
    Tagpagination.innerHTML = "";
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

        Tagpagination.appendChild(button);
    }
}
