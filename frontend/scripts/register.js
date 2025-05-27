document.addEventListener('DOMContentLoaded', function() {
    
    const errMsg = document.querySelector('#err-msg');

    const registerForm = document.querySelector('#register-form');

    registerForm.addEventListener('submit', function(event) {
        const email = document.querySelector('#email-input').value;
        const username = document.querySelector('#username-input').value;
        const password = document.querySelector('#password-input').value;
        const confirmPassword = document.querySelector('#confirm-password-input').value;

        if (!email || !username || !password || !confirmPassword) {
            errMsg.innerHTML = 'All fields are required.';
            event.preventDefault();
            return;
        } else if (password !== confirmPassword) {
            errMsg.innerHTML = 'Passwords do not match.';
            event.preventDefault();
            return;
        } else if (username.length < 3 || username.length > 20) {
            errMsg.innerHTML = 'Username must be between 3 and 20 characters.';
            event.preventDefault();
            return;
        } else if (password.length < 6 || !password.match(/^(?=.*[a-zA-Z])(?=.*\d).+$/)) {
            errMsg.innerHTML = 'Password must be at least 6 characters long and contain both letters and numbers.';
            event.preventDefault();
            return;
        } else {
            errMsg.innerHTML = '';
        }
    })

})