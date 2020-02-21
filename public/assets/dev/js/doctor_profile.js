let profileNav = document.getElementsByClassName("profile__nav-link");
let profileTab = document.getElementsByClassName("profile__details");

for(let j = 0; j < profileTab.length; j++) {
    profileTab[j].style.display = "none";
}

profileTab[0].style.display = "block";
profileNav[0].classList.add('active');

for(let i = 0; i < profileNav.length; i++) {
    document.getElementsByClassName("profile__nav-link")[i].addEventListener("click", () => {
        for(let j = 0; j < profileTab.length; j++) {
            profileTab[j].style.display = "none";
            profileNav[j].classList.remove('active');
        }
        profileTab[i].style.display = "block";
        profileNav[i].classList.add('active');
    });
}