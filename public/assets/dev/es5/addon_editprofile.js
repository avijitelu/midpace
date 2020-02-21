"use strict";

var editBtn = document.getElementsByClassName("edu-edit");
var updateBtn = document.getElementsByClassName("update-form__btn");
var closeBtn = document.getElementsByClassName("edu-close"); // hide and show the edit button

var _loop = function _loop(i) {
  editBtn[i].nextElementSibling.style.display = "none";
  editBtn[i].addEventListener("click", function (event) {
    var editForm = editBtn[i].nextElementSibling.style.display;

    if (editForm === "none") {
      editBtn[i].nextElementSibling.style.display = "block";
    } else {
      editBtn[i].nextElementSibling.style.display = "none";
    }
  });
};

for (var i = 0; i < editBtn.length; i++) {
  _loop(i);
} // ajax request for deleting information


var _loop2 = function _loop2(i) {
  var targetURL = closeBtn[i].getAttribute("data-href");
  closeBtn[i].addEventListener("click", function () {
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        closeBtn[i].parentElement.style.display = "none";
      }
    };

    xhttp.open("GET", targetURL, true);
    xhttp.send();
  });
};

for (var i = 0; i < closeBtn.length; i++) {
  _loop2(i);
}