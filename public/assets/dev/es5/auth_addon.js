"use strict";

var authAddon = function () {
  var loginBtn = document.getElementById("js-login-full__btn");
  var emailField = document.getElementById("js-login-full__email");
  var pswField = document.getElementById("js-login-full__psw");
  return {
    loginValidation: function loginValidation() {
      var _this = this;

      loginBtn.addEventListener("click", function (event) {
        event.preventDefault();
        var emailPattern = /^([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22))*\x40([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d))*$/;
        var error = false;

        if (emailField.value.length > 0) {
          if (!emailPattern.test(emailField.value)) {
            _this.createErrorMsg("js-login-full__email", "Invalid email");

            error = true;
          } else {
            _this.removeErrorMsg("js-login-full__email");
          }
        } else {
          _this.createErrorMsg("js-login-full__email", "Enter email");

          error = true;
        }

        if (pswField.value.length > 0) {
          _this.removeErrorMsg("js-login-full__psw");
        } else {
          _this.createErrorMsg("js-login-full__psw", "Enter password");

          error = true;
        }

        if (!error) {
          document.getElementById("js-login-full__form").submit();
        }
      });
    },

    /**
     * @desc    Create a next sibling element
     * @param {*String} elemId (ID of an element)
     * @param {*String} msg (Text message)
     */
    createErrorMsg: function createErrorMsg(elemId, msg) {
      if (document.getElementById(elemId).nextElementSibling) {
        document.getElementById(elemId).nextElementSibling.textContent = msg;
      } else {
        var msgElem = document.createElement("P");
        msgElem.innerText = msg;
        msgElem.classList.add("error_msg");
        document.getElementById(elemId).insertAdjacentElement("afterend", msgElem);
      }
    },

    /**
     * @desc    remove next sibling element
     * @param {*String} elemId (ID of an element)
     */
    removeErrorMsg: function removeErrorMsg(elemId) {
      if (document.getElementById(elemId).nextElementSibling) {
        var elem = document.getElementById(elemId).nextElementSibling;
        elem.parentNode.removeChild(elem);
      }
    }
  };
}();

authAddon.loginValidation();