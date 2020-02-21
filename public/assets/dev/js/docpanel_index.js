const toggleBtn = document.querySelector('.togggle-btn');
toggleBtn.addEventListener('click', function() {
    // confirm('Do you want to active your booking status?');
    this.classList.toggle('toggle-active');
    if(this.classList.contains('toggle-active')) {
        this.setAttribute('data-switch', 'on');
    } else {
        this.setAttribute('data-switch', 'off');
    }

    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
        }
    }
    xhttp.open('POST', BASE_HREF + '/docpanel/booking-status', true);
    xhttp.send();
})

// Modal configuration
const modals = document.querySelectorAll('.modal');
const modalCloseBtns = document.querySelectorAll('.modal__close-btn');
const modalOpenBtns = document.querySelectorAll('.modal__open');
modalOpenBtns.forEach(function(modalOpenBtn) {
    modalOpenBtn.addEventListener('click', function() {
        const modalId = this.getAttribute('data-modal');
        document.getElementById(modalId).style.display = 'flex';
    })
})
modalCloseBtns.forEach(function(modalCloseBtn) {
    modalCloseBtn.addEventListener('click', function() {
        this.parentElement.parentElement.style.display = 'none';
    })
})
modals.forEach(function(modal) {
    modal.addEventListener('click', function(event) {
        if(event.target === modal) {
            this.style.display = 'none';
        }
    })
})

// Delete btn Confirmation popup
const deleteForm = document.getElementById('delete-form');
const deleteBtn = document.getElementById('delete-btn');
deleteBtn.addEventListener('click', function(event) {
    event.preventDefault();
    let response = confirm('Are you sure, want to delete the list?');
    if(response) {
        deleteForm.submit();
    }
})

const docpanel_index = (function(){
    return {
        urgentNoticeValidation: function() {
            const noticeForm = document.getElementById('js-docnotice__form');
            const noticeBtn = document.getElementById('js-notice-btn');
            const notice = document.getElementById('js-urgent-notice');
            const stringPattern = /^[a-zA-Z- ]*$/;
            const notWhitespacePattern = /\S/g;

            noticeBtn.addEventListener('click', function(event) {
                event.preventDefault();
                let error = false;

                if(notWhitespacePattern.test(notice.value)) {
                    if(!stringPattern.test(notice.value)) {
                        notice.nextElementSibling.textContent = 'Enter your message';
                        error = true;
                    } else {
                        notice.nextElementSibling.textContent = '';
                    }
                } else {
                    notice.nextElementSibling.textContent = 'Enter name';
                    error = true;
                }

                if(!error) {
                    noticeForm.submit();
                }
            })
        }
    }
})();

// docpanel_index.urgentNoticeValidation();