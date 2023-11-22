const searchUserInput = document.getElementById("searchUserInput");
const usersContainer = document.querySelector(".users");
const sortSelect = document.getElementById("sortSelect");
let currentPage = 1; 
document.addEventListener("DOMContentLoaded", function () {

    searchUserInput.addEventListener("input", function () {
        searchUsers();
    });

    sortSelect.addEventListener("change", function () {
        searchUsers();
    });

});
function searchUsers(){
    const query = searchUserInput.value;
    const sortBy = sortSelect.value;
    currentPage = 1; 

    fetch(`/search/users?q=${query}&SearchBy=${sortBy}`)
        .then(response => response.json())
        .then(data => {
            displayResults(data);
        })
        .catch(error => {
            console.error('Error fetching sorted search results', error);
        });

}
function displayResults(results) {

        usersContainer.innerHTML = '';

        if (results.length === 0) {
            usersContainer.innerHTML = '<p>No users found.</p>';
            return;
        }
        
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

