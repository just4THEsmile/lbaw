const searchInput = document.getElementById("searchInput");
const searchResults = document.getElementById("searchResults");
const searchOrderedBy_Selector = document.getElementById("sortSelect");
const questionpagination = document.getElementById("QuestionPagination")


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
    fetch(`/api/search/questions?OrderBy=${searchOrderedBy_Selector.value}&q=${query}`)

        .then(response => response.json())
        .then(data => {
            if(searchInput.value==query){

        
                results = data;
                showPage(data.data,data.links);
            }

    })
    .catch(error => {
        console.error('Error fetching search results', error);
    });
}


window.onload = function () {
    searchQuestions();
}   

function showPage(results,links){
    searchResults.innerHTML = "";
    if(results.length == 0){
        searchResults.innerHTML = "No questions Found";
    }
    for (let i = 0; i < results.length; i++) {
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

        const questionbottom= document.createElement("div");
        questionbottom.classList.add("questionbottom");

        const questiontags = document.createElement("div");
        questiontags.classList.add("tags");

       // Split the comma-separated strings into arrays
       const tagsArray = result.tags ? result.tags.split(',') : [result.tags];
       const tagsidArray = result.tagsid ? result.tagsid.split(',') : [result.tagsid];

        // Create a dictionary object with tag IDs as keys and tag names as values
        for (let i = 0; i < tagsArray.length; i++) {
            const tagElement = document.createElement("div");
            tagElement.classList.add("tag");
        
            const tagLink = document.createElement("a");
            tagLink.href = `/tag/${tagsidArray[i]}`;
            tagLink.textContent = tagsArray[i];
        
            tagElement.appendChild(tagLink);
            questiontags.appendChild(tagElement);
        }


        contentDiv.appendChild(questionLink);

        profileInfoDiv.appendChild(userProfileLink);
        profileInfoDiv.appendChild(questionDate);

        questionbottom.appendChild(questiontags);
        questionbottom.append(profileInfoDiv);

        contentDiv.appendChild(questionbottom);

        questionCard.appendChild(votes);
        questionCard.appendChild(contentDiv);

        // Append the answer card to the search results
        searchResults.appendChild(questionCard);
        
    }
    renderPaginationButtons(links);
}
function renderPaginationButtons(links) {
    query = searchInput.value;
    const paginationContainer = document.getElementById("QuestionPagination")
    paginationContainer.innerHTML = "";
    for (let i = 0; i <links.length; i++) {
        const button = document.createElement("button");
        button.innerHTML = links[i].label;
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

