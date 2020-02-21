"use strict";

var toggleBtn = document.querySelector('.togggle-btn');
toggleBtn.addEventListener('click', function () {
  // confirm('Do you want to active your booking status?');
  this.classList.toggle('toggle-active');

  if (this.classList.contains('toggle-active')) {
    this.setAttribute('data-switch', 'on');
  } else {
    this.setAttribute('data-switch', 'off');
  }

  var xhttp = new XMLHttpRequest();

  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
    }
  };

  xhttp.open('POST', BASE_HREF + '/docpanel/booking-status', true);
  xhttp.send();
}); // Modal configuration

var modals = document.querySelectorAll('.modal');
var modalCloseBtns = document.querySelectorAll('.modal__close-btn');
var modalOpenBtns = document.querySelectorAll('.modal__open');
modalOpenBtns.forEach(function (modalOpenBtn) {
  modalOpenBtn.addEventListener('click', function () {
    var modalId = this.getAttribute('data-modal');
    document.getElementById(modalId).style.display = 'flex';
  });
});
modalCloseBtns.forEach(function (modalCloseBtn) {
  modalCloseBtn.addEventListener('click', function () {
    this.parentElement.parentElement.style.display = 'none';
  });
});
modals.forEach(function (modal) {
  modal.addEventListener('click', function (event) {
    if (event.target === modal) {
      this.style.display = 'none';
    }
  });
}); // Delete btn Confirmation popup

var deleteForm = document.getElementById('delete-form');
var deleteBtn = document.getElementById('delete-btn');
deleteBtn.addEventListener('click', function (event) {
  event.preventDefault();
  var response = confirm('Are you sure, want to delete the list?');

  if (response) {
    deleteForm.submit();
  }
});

var docpanel_index = function () {
  return {
    urgentNoticeValidation: function urgentNoticeValidation() {
      var noticeForm = document.getElementById('js-docnotice__form');
      var noticeBtn = document.getElementById('js-notice-btn');
      var notice = document.getElementById('js-urgent-notice');
      var stringPattern = /^[a-zA-Z- ]*$/;
      var notWhitespacePattern = /\S/g;
      noticeBtn.addEventListener('click', function (event) {
        event.preventDefault();
        var error = false;

        if (notWhitespacePattern.test(notice.value)) {
          if (!stringPattern.test(notice.value)) {
            notice.nextElementSibling.textContent = 'Enter your message';
            error = true;
          } else {
            notice.nextElementSibling.textContent = '';
          }
        } else {
          notice.nextElementSibling.textContent = 'Enter name';
          error = true;
        }

        if (!error) {
          noticeForm.submit();
        }
      });
    }
  };
}(); // docpanel_index.urgentNoticeValidation();