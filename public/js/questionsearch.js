document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const searchResults = document.getElementById("searchResults");
    let currentPage = 1; 
    searchInput.addEventListener("input", function () {

    

        const query = searchInput.value;

        // Perform an AJAX request to your Laravel backend
        $currentPage = 1;
        fetch(`/search/questions?q=${query}`)
            .then(response => response.json())
            .then(data => {
                // Update the search results in the DOM
                displayResults(data);
                
            })
            .catch(error => {
                console.error('Error fetching search results', error);
            });});

            function displayResults(results) {
                console.log(results);
                // Clear previous results
                searchResults.innerHTML = "";
                // Display new results
                results.forEach(result => {
                    // Create the main answer card div
                    const answerCard = document.createElement("div");
                    answerCard.classList.add("answercard");
            
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

                    // Create a link for the username
                    const usernameLink = document.createElement("a");
                    usernameLink.href = `/user/${result.userid}`;
                    usernameLink.textContent = result.username; // Adjust based on your actual result structure
                    usernameLink.classList.add("username");

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
                    contentDiv.appendChild(usernameLink);
                    contentDiv.appendChild(dateParagraph);  
            
                    // Append elements to the answer card div
                    answerCard.appendChild(titleLink);
                    answerCard.appendChild(contentDiv);
            
                    // Append the answer card to the search results
                    searchResults.appendChild(answerCard);
                });
            }
});