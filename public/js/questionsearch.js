document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const searchResults = document.getElementById("searchResults");

    searchInput.addEventListener("input", function () {

    

        const query = searchInput.value;

        // Perform an AJAX request to your Laravel backend
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
            // Clear previous results
            searchResults.innerHTML = "";
        
            // Display new results
            results.forEach(result => {
                // Create a link for each result
                const link = document.createElement("a");
                link.href = `/question/${result.id}`; // Assuming there's an 'id' property in your result
                link.textContent = result.title; // Adjust this based on your actual result structure
        
                // Create a list item and append the link to it
                const listItem = document.createElement("li");
                listItem.appendChild(link);
        
                // Append the list item to the search results
                searchResults.appendChild(listItem);
            });
        }
});