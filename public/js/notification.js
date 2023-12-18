function loadNotifications(){
    const error = document.getElementById("errorNotifications");
    const notification_counter = document.getElementById("notification_numbers");
    fetch(`/notification/number`)
    .then(response => {
        if (response.status == 200) {
            return response.json();
        }else{
            return response.json().then(error1 => {
                if(error1.message != "Not logged in"){
                    error.textContent = "Error fetching notifications";
                }
            });
        }
    })
    .then(data => {
        try{        
            if(data > 0){
            notification_counter.textContent = data;
            }else{
                notification_counter.hidden = true;
            }
        }catch(err){
            
        }

    })
    .catch(error => {
        console.error('Error fetching search results', error);
    });
}
window.onload = function() {
    loadNotifications();
  };