const searchUserInput = document.getElementById("searchUserInput");
const usersContainer = document.querySelector(".users");
let currentPage = 1; 
document.addEventListener("DOMContentLoaded", function () {

    searchUserInput.addEventListener("input", function () {
        searchUsers();
    });


});
function searchUsers(){
    const query = searchUserInput.value;
    currentPage = 1; 

    fetch(`/search/users?q=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            displayResults(data);
        })
        .catch(error => {
            console.error('Error fetching search results', error);
        });

}
function displayResults(results) {

        let baseURL = window.location.protocol + '//' + window.location.host;

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
            profileImg.src = `${baseURL}/profile/${user.profilepicture}`; 
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

