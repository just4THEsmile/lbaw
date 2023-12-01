const searchInput = document.getElementById("searchTagInput");

document.addEventListener("DOMContentLoaded", function () {

    searchInput.addEventListener("input", function () {
        updateTags();
    });
});

function updateTags(){
    const query = searchInput.value;
    // Perform an AJAX request to your Laravel backend
    fetch(`/api/fullsearch/tag?query=${query}`)
        .then(response => response.json())
        .then(data => {
            if(query==searchInput.value){
                showPage(data.data,data.links);   
            }
        })
        .catch(error => {
            console.error('Error fetching search results', error);
        });

}
window.onload = function () {
    updateTags();
}   

function showPage(results,links){
    const Tags = document.getElementById("Tags");
    Tags.innerHTML = "";
    if(results.length == 0){
        Tags.innerHTML = "No Tags Found";
    }
    for (let i = 0; i < results.length; i++) {
        let result = results[i];
        // Create the main Tag card div
        const TagCard = document.createElement("div");
        TagCard.classList.add("Tagcard");

        // Create the content div
        const contentDiv = document.createElement("div");
        contentDiv.classList.add("content");

        // Create a paragraph for the Tag content
        const contentParagraph = document.createElement("p");

        if(result.description.length > 100){
            contentParagraph.textContent = result.description.substring(0,100) + "...";
        }else{
            contentParagraph.textContent = result.description;
        }
        const titleLink = document.createElement("a");
        titleLink.href = `/Tag/${result.id}`;
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
    renderPaginationButtons(links);
}
function renderPaginationButtons(links) {
    const paginationContainer = document.getElementById("TagsPagination")
    query = searchInput.value;
    paginationContainer.innerHTML = "";
    for (let i = 0; i <links.length; i++) {
        const button = document.createElement("button");
        button.textContent = links[i].label;
        button.classList.add("pagination-button");
        // Highlight the current page
        button.addEventListener("click", function () {
            if(links[i].url!=null){
                fetch(links[i].url)

                .then(response => response.json())
                .then(data => {
                    if(searchInput.value==query){
                        results = data;
                        showPage(data.data,data.links);
                        window.scrollTo(0,0); 
                    }
        
                })
                .catch(error => {
                    console.error('Error fetching search results', error);
                });
        } 
        });

        paginationContainer.appendChild(button);
    }
}
