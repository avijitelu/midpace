let doctorListing = (function() {
    let loadMoreBtn = document.getElementById("js-loadmore-btn");
    let filterBtn = document.querySelector('.category-filter');
    let filterContainer = document.querySelector('.mob-category');
    let filterLink = document.querySelector('.mob-category__link');

    return {
        // ajax call for load more doctors
        loadDoctors: function () {
            let page = 1;
            if(document.getElementById("js-loadmore-link")) {
                let ajax_url = document.getElementById("js-loadmore-link").getAttribute("ajaxify");
                loadMoreBtn.addEventListener("click", event => {
                    page = page + 1;
                    let url = ajax_url + "&page=" + page
    
                    let xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("js-listing").innerHTML += this.responseText;
                            document.getElementById("js-spinner-box").style.display = "none";
                            // remove the loadmore button when all pages are load
                            if (page == noOfPages) {
                                loadMoreBtn.parentNode.removeChild(loadMoreBtn);
                            }
    
                        } else {
                            document.getElementById("js-spinner-box").style.display = "flex";
                        }
                    };
                    xhttp.open("GET", url, true);
                    xhttp.send();
                });
            }
        },

        mobileCategoryFilter: function() {
            filterBtn.addEventListener('click', (event) => {
                filterContainer.classList.toggle('mob-category__active');
            });

            filterLink.addEventListener('click', (e) => {
                filterContainer.classList.remove('mob-category__active');
            })
        }
    }
})();

doctorListing.loadDoctors();
doctorListing.mobileCategoryFilter();