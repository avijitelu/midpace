"use strict";

var regForm = function () {
  return {
    regFormValidation: function regFormValidation() {
      var regForm = document.getElementById("js-form-reg");
      var submit = document.getElementById("reg-submit-btn");
      submit.addEventListener("click", function (event) {
        event.preventDefault();
        var fname = document.getElementById("js-reg-fname");
        var lname = document.getElementById("js-reg-lname");
        var mode = document.getElementById("js-reg-mode");
        var speciality = document.getElementById("js-reg-speciality");
        var email = document.getElementById("js-reg-email");
        var password = document.getElementById("js-reg-psw");
        var confPassword = document.getElementById("js-reg-confpsw");
        var error = false;
        var stringPattern = /^[a-zA-Z- ]*$/;
        var emailPattern = /^([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22))*\x40([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d))*$/;

        if (fname.value.length > 0) {
          if (!stringPattern.test(fname.value)) {
            document.getElementById("err-fname").textContent = "Only accept alphabets and space";
            fname.style.border = "1px solid #e51c23";
            error = true;
          } else {
            document.getElementById("err-fname").textContent = "";
            fname.style.border = "1px solid #cecece";
          }
        } else {
          document.getElementById("err-fname").textContent = "Enter firstname";
          fname.style.border = "1px solid #e51c23";
          error = true;
        }

        if (lname.value.length > 0) {
          if (!stringPattern.test(lname.value)) {
            document.getElementById("err-lname").textContent = "Only accept alphabets and space";
            lname.style.border = "1px solid #e51c23";
            error = true;
          } else {
            document.getElementById("err-lname").textContent = "";
            lname.style.border = "1px solid #cecece";
          }
        } else {
          document.getElementById("err-lname").textContent = "Enter lastname";
          lname.style.border = "1px solid #e51c23";
          error = true;
        }

        if (mode.value.length > 0) {
          if (!stringPattern.test(mode.value)) {
            document.getElementById("err-mode").textContent = "Only accept alphabets and space";
            mode.style.border = "1px solid #e51c23";
            error = true;
          } else {
            document.getElementById("err-mode").textContent = "";
            mode.style.border = "1px solid #cecece";
          }
        } else {
          document.getElementById("err-mode").textContent = "Select mode";
          mode.style.border = "1px solid #e51c23";
          error = true;
        }

        if (speciality.value.length > 0) {
          if (!stringPattern.test(speciality.value)) {
            document.getElementById("err-speciality").textContent = "Only accept alphabets and space";
            speciality.style.border = "1px solid #e51c23";
            error = true;
          } else {
            document.getElementById("err-speciality").textContent = "";
            speciality.style.border = "1px solid #cecece";
          }
        } else {
          document.getElementById("err-speciality").textContent = "Select specialization";
          speciality.style.border = "1px solid #e51c23";
          error = true;
        }

        if (email.value.length > 0) {
          if (!emailPattern.test(email.value)) {
            document.getElementById("err-email").textContent = "Invalid email";
            email.style.border = "1px solid #e51c23";
            error = true;
          } else {
            document.getElementById("err-email").textContent = "";
            email.style.border = "1px solid #cecece";
          }
        } else {
          document.getElementById("err-email").textContent = "Enter email";
          email.style.border = "1px solid #e51c23";
          error = true;
        }

        if (password.value.length > 0) {
          document.getElementById("err-psw").textContent = "";
          password.style.border = "1px solid #cecece";
        } else {
          document.getElementById("err-psw").textContent = "Enter password";
          password.style.border = "1px solid #e51c23";
          error = true;
        }

        if (confPassword.value === password.value) {
          document.getElementById("err-confpsw").textContent = "";
          confPassword.style.border = "1px solid #cecece";
        } else {
          document.getElementById("err-confpsw").textContent = "Password doesn't match";
          confPassword.style.border = "1px solid #e51c23";
          error = true;
        }

        if (!error) {
          regForm.submit();
        }
      });
    }
  };
}();

regForm.regFormValidation();