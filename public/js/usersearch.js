const searchInput = document.getElementById("searchUserInput");

document.addEventListener("DOMContentLoaded", function () {

    searchInput.addEventListener("input", function () {
        searchUsers();
    });

    sortSelect.addEventListener("change", function () {
        searchUsers();
    });

});
window.onload = function () {
    searchUsers();
    loadNotifications();
}
function searchUsers(){
    const sortSelect = document.getElementById("sortSelect");
    const query = searchInput.value;
    const sortBy = sortSelect.value;
    const error = document.getElementById("error");

    fetch(`/search/users?q=${encodeURIComponent(query)}&SearchBy=${sortBy}`)
        .then(response => {         
            if (response.status == 200) {
                return response.json();
            }else{
                error.textContent = "Error fetching users";
            }
        })
        .then(data => {
            if(query== searchInput.value && sortBy == sortSelect.value){
                showPage(data.data, data.links);
            }
        })
        .catch(error => {
            console.error('Error fetching sorted search results', error);
        });

}
function showPage(results,links) {
    const usersContainer = document.querySelector(".users");
    let baseURL = window.location.protocol + '//' + window.location.host;

    usersContainer.innerHTML = '';

    if (results.length === 0) {
        usersContainer.innerHTML = '<p>No users found.</p>';
        return;
    }
    for (let i = 0; i < results.length; i++) {
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
        renderPaginationButtons(links);
}


