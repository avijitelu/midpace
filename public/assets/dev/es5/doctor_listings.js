"use strict";

var doctorListing = function () {
  var loadMoreBtn = document.getElementById("js-loadmore-btn");
  var filterBtn = document.querySelector('.category-filter');
  var filterContainer = document.querySelector('.mob-category');
  var filterLink = document.querySelector('.mob-category__link');
  return {
    // ajax call for load more doctors
    loadDoctors: function loadDoctors() {
      var page = 1;

      if (document.getElementById("js-loadmore-link")) {
        var ajax_url = document.getElementById("js-loadmore-link").getAttribute("ajaxify");
        loadMoreBtn.addEventListener("click", function (event) {
          page = page + 1;
          var url = ajax_url + "&page=" + page;
          var xhttp = new XMLHttpRequest();

          xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
              document.getElementById("js-listing").innerHTML += this.responseText;
              document.getElementById("js-spinner-box").style.display = "none"; // remove the loadmore button when all pages are load

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
    mobileCategoryFilter: function mobileCategoryFilter() {
      filterBtn.addEventListener('click', function (event) {
        filterContainer.classList.toggle('mob-category__active');
      });
      filterLink.addEventListener('click', function (e) {
        filterContainer.classList.remove('mob-category__active');
      });
    }
  };
}();

doctorListing.loadDoctors();
doctorListing.mobileCategoryFilter();