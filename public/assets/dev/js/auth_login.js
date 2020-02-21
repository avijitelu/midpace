let loginForm = (function() {
    return {
        loginFormValidation: function() {
            const loginForm = document.getElementById("js-login__form");
            const loginBtn = document.getElementById("js-login-btn");
            const email = document.getElementById("js-login-email");
            const password = document.getElementById("js-login-password");
            const stringPattern = /^[a-zA-Z- ]*$/;
            const emailPattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

            loginBtn.addEventListener('click', function(event) {
                event.preventDefault();
                let error = false;

                if(email.value.length > 0) {
                    if(!emailPattern.test(email.value)) {
                        email.nextElementSibling.textContent = 'Invalid email id';
                        error = true;
                    } else {
                        email.nextElementSibling.textContent = '';
                    }
                } else {
                    email.nextElementSibling.textContent = 'Enter email';
                    error = true;
                }

                if(password.value.length > 0) {
                    password.nextElementSibling.textContent = '';
                } else {
                    password.nextElementSibling.textContent = 'Enter password';
                    error = true;
                }
                
                if(!error) {
                    loginForm.submit();
                }
            })
        }
    }
})();

loginForm.loginFormValidation();