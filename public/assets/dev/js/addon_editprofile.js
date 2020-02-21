let editBtn = document.getElementsByClassName("edu-edit");
let updateBtn = document.getElementsByClassName("update-form__btn");
let closeBtn = document.getElementsByClassName("edu-close");

// hide and show the edit button
for(let i = 0; i < editBtn.length; i++) {
    editBtn[i].nextElementSibling.style.display = "none";
    editBtn[i].addEventListener("click", (event) => {
        let editForm = editBtn[i].nextElementSibling.style.display;

        if(editForm === "none") {
            editBtn[i].nextElementSibling.style.display = "block";
        } else {
            editBtn[i].nextElementSibling.style.display = "none";
        }
    });
}


// ajax request for deleting information
for(let i = 0; i < closeBtn.length; i++) {
    let targetURL = closeBtn[i].getAttribute("data-href");
    closeBtn[i].addEventListener("click", () => {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200) {
                closeBtn[i].parentElement.style.display = "none";
            }
        }
        xhttp.open("GET", targetURL , true);
        xhttp.send();
    });
}