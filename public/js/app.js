function disableSubmitButton() {
  let submitButtons = document.querySelectorAll('button[type="submit"]');
            
  for (let i = 0; i < submitButtons.length; i++) {
      submitButtons[i].disabled = true;
  }
  setTimeout(function () {
    for (let i = 0; i < submitButtons.length; i++) {
      submitButtons[i].disabled = false;
    }
  }, 4000);
}

function confirmDelete() {
  return confirm("Are you sure you want to delete the account?");
}

function confirmBlock() {
  return confirm("Are you sure you want to proceed with the action?");
}
function encodeForAjax(data) {
  if (data == null) return null;
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&');
}

function sendAjaxRequest(method, url, data, handler) {
  let request = new XMLHttpRequest();

  request.open(method, url, true);
  request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  request.addEventListener('load', handler);
  request.send(encodeForAjax(data));
}
function renderPaginationButtons(links) {
    use_query = true;
    try{
      query = searchInput.value;
    }catch(error){
      use_query = false;
    }
  const paginationContainer = document.getElementById("pagination")
  paginationContainer.innerHTML = "";
  for (let i = 0; i <links.length; i++) {
      const button = document.createElement("button");
      button.innerHTML = links[i].label;
      if(links[i].active){
          button.classList.add("active");
      }else{
          button.classList.add("page-item");
      }
      button.addEventListener("click", function () {
          if(links[i].url!=null){
              fetch(links[i].url)

              .then(response => response.json())
              .then(data => {
                  if(use_query){
                    if(searchInput.value==query){
                      results = data;
                      showPage(data.data,data.links);
                      window.scrollTo(0,0); 
                   }
                  }else{
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