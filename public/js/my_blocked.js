const Blocked = document.getElementById("Blocked");
const blockedpagination = document.getElementById("BlockedPagination")
const blockedPerPage = 5;
let results = [];

function updateBlocked(){
    let currentPage = 1;
        fetch(`/api/myblocked/${user_id.textContent}`)
            .then(response => {
                if (response.status == 200) {
                    return response.json();
                }else{
                    error.textContent = "Error fetching blocked content";
                }
            })
            .then(data => {
                // Update the search results in the DOM
                results = data;
                showPage(currentPage);   
            })
            .catch(error => {
                console.error('Error fetching search results', error);
            });
}

window.onload = function () {
    updateBlocked();
}

function showPage(currentPage){
    Blocked.innerHTML = "";
    if(results.length == 0){
        Blocked.innerHTML = "No Blocked Content Found";
    }
    for (let i = (currentPage - 1)*blockedPerPage; i < results.length && i<currentPage*blockedPerPage ; i++) {
        let result = results[i];
        const blockedCard = document.createElement("div");
        blockedCard.classList.add("blocked");

        const blockedName = document.createElement("p");
        blockedName.classList.add("blockedname");
        blockedName.textContent = result.content; 



        // Create the <button> element for unblock with the class "unblock"
        const unblock = document.createElement("a");
        unblock.setAttribute('href', '/api/unblockrequest/' + result.id + '?user_id=' + result.user_id);
        unblock.classList.add("unblock");
        unblock.textContent = "Request unblock";

        // Add the <p> element to the answer card div
        blockedCard.appendChild(blockedName);
        blockedCard.appendChild(unblock);

        // Add the answer card div to the answers div
        Blocked.appendChild(blockedCard);
    }
}