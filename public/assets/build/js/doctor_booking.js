"use strict";var bookingForm={bookingFormValidation:function(){var n=document.getElementById("js-booking__form"),e=document.getElementById("js-booking-btn"),o=document.getElementById("js-booking-name"),l=document.getElementById("js-booking-mobile"),i=document.getElementById("js-booking-location"),m=document.getElementById("js-booking-docId"),a=/^[6-9]\d{9}$/,g=/^[0-9]*$/,b=/^[a-zA-Z- ]*$/,d=/\S/g;e.addEventListener("click",function(e){e.preventDefault();var t=!1;d.test(o.value)?b.test(o.value)?o.nextElementSibling.textContent="":(o.nextElementSibling.textContent="Only accept alphabets and space",t=!0):(o.nextElementSibling.textContent="Enter name",t=!0),0<l.value.length?a.test(l.value)?l.nextElementSibling.textContent="":(l.nextElementSibling.textContent="Invalid mobile number",t=!0):(l.nextElementSibling.textContent="Enter mobile number",t=!0),0<i.value.length&&(b.test(i.value)?i.nextElementSibling.textContent="":(i.nextElementSibling.textContent="Invaild input character",t=!0)),0<m.value.length&&g.test(m.value)||(t=!0),t||n.submit()})}};bookingForm.bookingFormValidation();