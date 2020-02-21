"use strict";

var loginForm = function () {
  return {
    loginFormValidation: function loginFormValidation() {
      var loginForm = document.getElementById("js-login__form");
      var loginBtn = document.getElementById("js-login-btn");
      var email = document.getElementById("js-login-email");
      var password = document.getElementById("js-login-password");
      var stringPattern = /^[a-zA-Z- ]*$/;
      var emailPattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      loginBtn.addEventListener('click', function (event) {
        event.preventDefault();
        var error = false;

        if (email.value.length > 0) {
          if (!emailPattern.test(email.value)) {
            email.nextElementSibling.textContent = 'Invalid email id';
            error = true;
          } else {
            email.nextElementSibling.textContent = '';
          }
        } else {
          email.nextElementSibling.textContent = 'Enter email';
          error = true;
        }

        if (password.value.length > 0) {
          password.nextElementSibling.textContent = '';
        } else {
          password.nextElementSibling.textContent = 'Enter password';
          error = true;
        }

        if (!error) {
          loginForm.submit();
        }
      });
    }
  };
}();

loginForm.loginFormValidation();