"use strict";var mobileNavBtn=document.getElementById("js-mobile-nav"),navbar=document.getElementById("js-navbar__nav");window.innerWidth<=650&&(navbar.style.display="none"),mobileNavBtn.addEventListener("click",function(n){"none"==navbar.style.display?navbar.style.display="block":navbar.style.display="none"});