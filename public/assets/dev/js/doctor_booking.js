let bookingForm = (function() {
    return {
        bookingFormValidation: function() {
            const bookingForm = document.getElementById("js-booking__form");
            const bookingBtn = document.getElementById("js-booking-btn");
            const name = document.getElementById("js-booking-name");
            const mobile = document.getElementById("js-booking-mobile");
            const location = document.getElementById("js-booking-location");
            const docId = document.getElementById("js-booking-docId");
            // Regular Expression
            const mobilePattern = /^[6-9]\d{9}$/;
            const numberPattern = /^[0-9]*$/;
            const stringPattern = /^[a-zA-Z- ]*$/;
            const notWhitespacePattern = /\S/g;
            const emailPattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

            bookingBtn.addEventListener('click', function(event) {
                event.preventDefault();
                let error = false;

                if(notWhitespacePattern.test(name.value)) {
                    if(!stringPattern.test(name.value)) {
                        name.nextElementSibling.textContent = 'Only accept alphabets and space';
                        error = true;
                    } else {
                        name.nextElementSibling.textContent = '';
                    }
                } else {
                    name.nextElementSibling.textContent = 'Enter name';
                    error = true;
                }
                
                if(mobile.value.length > 0) {
                    if(!mobilePattern.test(mobile.value)) {
                        mobile.nextElementSibling.textContent = 'Invalid mobile number';
                        error = true;
                    } else {
                        mobile.nextElementSibling.textContent = '';
                    }
                } else {
                    mobile.nextElementSibling.textContent = 'Enter mobile number';
                    error = true;
                }

                if(location.value.length > 0) {
                    if(!stringPattern.test(location.value)) {
                        location.nextElementSibling.textContent = 'Invaild input character';
                        error = true;
                    } else {
                        location.nextElementSibling.textContent = '';
                    }
                }

                if(docId.value.length > 0) {
                    if(!numberPattern.test(docId.value)) {
                        error = true;
                    }
                } else {
                    error = true;
                }

                if(!error) {
                    bookingForm.submit();
                }
            })
        }
    }
})();

bookingForm.bookingFormValidation();