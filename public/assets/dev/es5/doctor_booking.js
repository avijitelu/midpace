"use strict";

var bookingForm = function () {
  return {
    bookingFormValidation: function bookingFormValidation() {
      var bookingForm = document.getElementById("js-booking__form");
      var bookingBtn = document.getElementById("js-booking-btn");
      var name = document.getElementById("js-booking-name");
      var mobile = document.getElementById("js-booking-mobile");
      var location = document.getElementById("js-booking-location");
      var docId = document.getElementById("js-booking-docId"); // Regular Expression

      var mobilePattern = /^[6-9]\d{9}$/;
      var numberPattern = /^[0-9]*$/;
      var stringPattern = /^[a-zA-Z- ]*$/;
      var notWhitespacePattern = /\S/g;
      var emailPattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      bookingBtn.addEventListener('click', function (event) {
        event.preventDefault();
        var error = false;

        if (notWhitespacePattern.test(name.value)) {
          if (!stringPattern.test(name.value)) {
            name.nextElementSibling.textContent = 'Only accept alphabets and space';
            error = true;
          } else {
            name.nextElementSibling.textContent = '';
          }
        } else {
          name.nextElementSibling.textContent = 'Enter name';
          error = true;
        }

        if (mobile.value.length > 0) {
          if (!mobilePattern.test(mobile.value)) {
            mobile.nextElementSibling.textContent = 'Invalid mobile number';
            error = true;
          } else {
            mobile.nextElementSibling.textContent = '';
          }
        } else {
          mobile.nextElementSibling.textContent = 'Enter mobile number';
          error = true;
        }

        if (location.value.length > 0) {
          if (!stringPattern.test(location.value)) {
            location.nextElementSibling.textContent = 'Invaild input character';
            error = true;
          } else {
            location.nextElementSibling.textContent = '';
          }
        }

        if (docId.value.length > 0) {
          if (!numberPattern.test(docId.value)) {
            error = true;
          }
        } else {
          error = true;
        }

        if (!error) {
          bookingForm.submit();
        }
      });
    }
  };
}();

bookingForm.bookingFormValidation();