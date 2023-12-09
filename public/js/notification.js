window.onload = function() {
    const error = document.getElementById("error");
    const notification_counter = document.getElementById("notification_numbers");
    fetch(`/notification/number`)
    .then(response => {
      console.log(response);
        if (response.status == 200) {
            return response.json();
        }else{
          error.textContent = "Error fetching notifications";
        }
    })
    .then(data => {
        if(data > 0){
            notification_counter.textContent = data;
        }else{
            notification_counter.hidden = true;
        }
    })
    .catch(error => {
        console.error('Error fetching search results', error);
    });
  };