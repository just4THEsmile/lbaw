const searchInput = document.getElementById("searchInput");
const searchResults = document.getElementById("searchResults");
const searchOrderedBy_Selector = document.getElementById("sortSelect");


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
    const tag_id = document.getElementById("tag_id").textContent;
    const error = document.getElementById("error");
    fetch(`/api/tag/${tag_id}/questions?OrderBy=${searchOrderedBy_Selector.value}&q=${encodeURIComponent(query)}`)

        .then(response => {         
            if (response.status == 200) {
                return response.json();
            }else{
                error.textContent = "Error fetching questions";
            }
        })
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

        const answernum = document.createElement("p");
        answernum.classList.add("answernum");
        answernum.textContent = result.answernum + " answers"; // Replace with actual data
        // Create the <p> element with the class "votesnum" and set its content dynamically using data from the server
        const votesNum = document.createElement("p");
        votesNum.classList.add("votesnum");
        votesNum.textContent = result.votes + " votes"; // Replace with actual data





        votes.appendChild(answernum);
        votes.appendChild(votesNum);


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
            if(tagsArray[i] == null) continue;
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

