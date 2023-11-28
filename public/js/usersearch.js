const searchUserInput = document.getElementById("searchUserInput");
const usersContainer = document.querySelector(".users");
const sortSelect = document.getElementById("sortSelect");
let currentPage = 1; 
const users_per_page = 18;
document.addEventListener("DOMContentLoaded", function () {

    searchUserInput.addEventListener("input", function () {
        searchUsers();
    });

    sortSelect.addEventListener("change", function () {
        searchUsers();
    });

});
window.onload = function () {
    searchUsers();
}
function searchUsers(){
    const query = searchUserInput.value;
    const sortBy = sortSelect.value;
    currentPage = 1;

    fetch(`/search/users?q=${query}&SearchBy=${sortBy}`)
        .then(response => response.json())
        .then(data => {
            if(query== searchUserInput.value && sortBy == sortSelect.value){
                displayResults(data);
            }
        })
        .catch(error => {
            console.error('Error fetching sorted search results', error);
        });

}
function displayResults(results) {

    let baseURL = window.location.protocol + '//' + window.location.host;

    usersContainer.innerHTML = '';

    if (results.length === 0) {
        usersContainer.innerHTML = '<p>No users found.</p>';
        return;
    }
    for (let i = (currentPage - 1)*users_per_page; i < results.length && i<currentPage*users_per_page ; i++) {
        let user = results[i];

        const userDiv = document.createElement('div');
        userDiv.classList.add('user');

        const userLink = document.createElement('a');
        userLink.href = `/profile/${user.id}`;

        const profileImg = document.createElement('img');
        profileImg.src = `${baseURL}/profile/${user.profilepicture}`; 
        profileImg.alt = 'Profile Picture';

        const Name = document.createElement('p');
        Name.textContent = `Name:`;
        const userName = document.createElement('h2');
        userName.textContent = `${user.name}`;
        
        const Username = document.createElement('p');
        Username.textContent = `Username:`;
        const userUsername = document.createElement('h2');
        userUsername.textContent = `${user.username}`;
    
        userLink.appendChild(profileImg);
        userLink.appendChild(Name);
        userLink.appendChild(userName);
        userLink.appendChild(Username);
        userLink.appendChild(userUsername);

        userDiv.appendChild(userLink);
        usersContainer.appendChild(userDiv);
    }
        renderPaginationButtons(results,currentPage);
}
function renderPaginationButtons(results) {
    const totalPages = Math.ceil(results.length / users_per_page );
    const paginationContainer = document.getElementById("pagination")
    paginationContainer.innerHTML = "";
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
            displayResults(results);
            
        });

        paginationContainer.appendChild(button);
    }
}

