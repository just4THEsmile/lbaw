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
}
function searchUsers(){
    const sortSelect = document.getElementById("sortSelect");
    const query = searchInput.value;
    const sortBy = sortSelect.value;


    fetch(`/search/users?q=${query}&SearchBy=${sortBy}`)
        .then(response => response.json())
        .then(data => {
            if(query== searchInput.value && sortBy == sortSelect.value){
                console.log(data);
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
function renderPaginationButtons(links) {
    query = searchInput.value;
    const paginationContainer = document.getElementById("pagination")
    paginationContainer.innerHTML = "";
    for (let i = 0; i <links.length; i++) {
        const button = document.createElement("button");
        button.innerHTML = links[i].label;
        if(links[i].active){
            button.classList.add("active");
        }else{
            button.classList.add("pagination-button");
        }
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

