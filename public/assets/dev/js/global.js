let mobileNavBtn = document.getElementById("js-mobile-nav");
let navbar = document.getElementById("js-navbar__nav");

if(window.innerWidth <= 650) {
    navbar.style.display = "none";
}

mobileNavBtn.addEventListener("click", event => {
    if(navbar.style.display == "none") {
        navbar.style.display = "block";
    } else {
        navbar.style.display = "none";
    }
})