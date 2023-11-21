document.addEventListener("DOMContentLoaded", function () {
    const searchUserInput = document.getElementById("searchUserInput");
    const usersContainer = document.querySelector(".users");
    let currentPage = 1; 
    searchUserInput.addEventListener("input", function () {

        const query = searchUserInput.value;

        // Perform an AJAX request to your Laravel backend
        $currentPage = 1;
        fetch(`/search/users?q=${query}`)
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
                // Clear existing user entries
                usersContainer.innerHTML = '';
        
                if (results.length === 0) {
                    usersContainer.innerHTML = '<p>No users found.</p>';
                    return;
                }
        
                // Render user entries based on search results
                results.forEach(user => {
                    const userDiv = document.createElement('div');
                    userDiv.classList.add('user');
        
                    const userLink = document.createElement('a');
                    userLink.href = `/profile/${user.id}`;
        
                    const profileImg = document.createElement('img');
                    profileImg.src = `storage/${user.profilepicture}`;
                    profileImg.alt = 'Profile Picture';
        
                    const userName = document.createElement('h2');
                    userName.textContent = `Name: ${user.name}`;
        
                    const userUsername = document.createElement('h2');
                    userUsername.textContent = `Username: ${user.username}`;
        
                    userLink.appendChild(profileImg);
                    userLink.appendChild(userName);
                    userLink.appendChild(userUsername);
        
                    userDiv.appendChild(userLink);
                    usersContainer.appendChild(userDiv);
                });
            }
});