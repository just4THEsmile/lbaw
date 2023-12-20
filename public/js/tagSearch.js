const searchInput = document.getElementById("searchTagInput");

document.addEventListener("DOMContentLoaded", function () {

    searchInput.addEventListener("input", function () {
        updateTags();
    });
});

function updateTags(){
    const query = searchInput.value;
    // Perform an AJAX request to your Laravel backend
    const error = document.getElementById("error");
    fetch(`/api/fullsearch/tag?query=${encodeURIComponent(query)}`)
        .then(response => {         
            if (response.status == 200) {
                return response.json();
            }else{
                error.textContent = "Error fetching tags";
            }
        })
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
    loadNotifications();
}   

function showPage(results,links){
    const usertype = document.getElementById("user_type").textContent;
    const Tags = document.getElementById("Tags");
    Tags.innerHTML = "";
    if(results.length == 0){
        Tags.innerHTML = "No Tags Found";
    }
    for (let i = 0; i < results.length; i++) {
        let result = results[i];
        // Create the main Tag card div
        const TagCard = document.createElement("li");
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
        titleLink.href = `/tag/${result.id}`;
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
        //admin buttons
        const buttonDiv = document.createElement("div");
        if(usertype == "admin"){
            const deleteform = document.createElement("form");
            deleteform.method = "POST";
            deleteform.action = `../tag/${result.id}/delete`;
            const crf = document.createElement("input");
            crf.type = "hidden";
            crf.name = "_token";
            crf.value = document.querySelector('meta[name="csrf-token"]').content;
            crf.autocomplete = "off";
            const deletespan = document.createElement("span");
            deletespan.classList.add("material-symbols-outlined");
            deletespan.textContent = "delete";
            const deletebutton = document.createElement("button");
            deletebutton.type = "submit";
            deletebutton.classList.add("delete");
            deletebutton.classList.add("material-icons");
            deletebutton.appendChild(deletespan);
            deleteform.appendChild(crf);
            deleteform.appendChild(deletebutton);
            // edit form
            const editform = document.createElement("form");
            editform.method = "GET";    
            editform.action = `../tag/${result.id}/edit`;
            const editspan = document.createElement("span");
            editspan.classList.add("material-symbols-outlined");
            editspan.textContent = "edit";
            const editbutton = document.createElement("button");
            editbutton.type = "submit";
            editbutton.classList.add("edit");
            editbutton.classList.add("material-icons")
            editbutton.appendChild(editspan);
            editform.appendChild(editbutton);
            buttonDiv.appendChild(deleteform);
            buttonDiv.appendChild(editform);
        }
        const followform = document.createElement("form");
        followform.method = "POST";
        followform.action = `../tag/${result.id}/followtag`;
        const crf1 = document.createElement("input");
        crf1.type = "hidden";
        crf1.name = "_token";
        crf1.value = document.querySelector('meta[name="csrf-token"]').content;
        crf1.autocomplete = "off";
        const followbutton = document.createElement("button");
        followbutton.type = "submit";
        followbutton.classList.add("follow");
        followbutton.classList.add("material-icons")
        if(result.followed){
            followbutton.classList.add("followed");
            followbutton.textContent = "unfollow";
        }else{
            followbutton.textContent = "follow";
        }
        followform.appendChild(crf1);
        followform.appendChild(followbutton);
        buttonDiv.appendChild( followform);
        contentDiv.appendChild(buttonDiv);
        // Append elements to the Tag card div
        TagCard.appendChild(contentDiv);

        // Append the Tag card to the search results
        Tags.appendChild(TagCard);
        
    }
    renderPaginationButtons(links);
}

