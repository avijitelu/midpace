"use strict";

var profileNav = document.getElementsByClassName("profile__nav-link");
var profileTab = document.getElementsByClassName("profile__details");

for (var j = 0; j < profileTab.length; j++) {
  profileTab[j].style.display = "none";
}

profileTab[0].style.display = "block";
profileNav[0].classList.add('active');

var _loop = function _loop(i) {
  document.getElementsByClassName("profile__nav-link")[i].addEventListener("click", function () {
    for (var _j = 0; _j < profileTab.length; _j++) {
      profileTab[_j].style.display = "none";

      profileNav[_j].classList.remove('active');
    }

    profileTab[i].style.display = "block";
    profileNav[i].classList.add('active');
  });
};

for (var i = 0; i < profileNav.length; i++) {
  _loop(i);
}