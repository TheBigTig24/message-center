document.addEventListener('DOMContentLoaded', function() {

    const errMsg = document.querySelector('#err-msg');

    const loginForm = document.querySelector('#login-form');

    loginForm.addEventListener('submit', function(event) {
        const username = document.querySelector('#email-input').value;
        const password = document.querySelector('#password-input').value;

        if (!username || !password) {
            errMsg.innerHTML = 'Please enter both username and password.';
            event.preventDefault();
        } else {
            errMsg.innerHTML = '';
        }        
    })
});

