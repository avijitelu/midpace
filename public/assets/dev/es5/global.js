"use strict";

var mobileNavBtn = document.getElementById("js-mobile-nav");
var navbar = document.getElementById("js-navbar__nav");

if (window.innerWidth <= 650) {
  navbar.style.display = "none";
}

mobileNavBtn.addEventListener("click", function (event) {
  if (navbar.style.display == "none") {
    navbar.style.display = "block";
  } else {
    navbar.style.display = "none";
  }
});