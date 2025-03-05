
document.addEventListener('DOMContentLoaded', () => {
    const passwordInputs = document.querySelectorAll('input[type="password"]');

    passwordInputs.forEach(passwordInput => {
        const wrapper = document.createElement('div');
        wrapper.classList.add('password-wrapper');
        wrapper.style.position = 'relative';

        passwordInput.parentNode.insertBefore(wrapper, passwordInput);

        wrapper.appendChild(passwordInput);

        const toggleButton = document.createElement('button');
        toggleButton.setAttribute('type', 'button');
        toggleButton.classList.add('password-toggle');
        toggleButton.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye-off">
                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                <line x1="1" y1="1" x2="23" y2="23"></line>
            </svg>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                <circle cx="12" cy="12" r="3"></circle>
            </svg>
        `;

        toggleButton.style.position = 'absolute';
        toggleButton.style.right = '10px';
        toggleButton.style.top = '50%';
        toggleButton.style.transform = 'translateY(-50%)';
        toggleButton.style.background = 'none';
        toggleButton.style.border = 'none';
        toggleButton.style.cursor = 'pointer';
        toggleButton.style.color = '#888';

        toggleButton.querySelector('.feather-eye').style.display = 'none';

        wrapper.appendChild(toggleButton);

        toggleButton.addEventListener('click', () => {
            const eyeOff = toggleButton.querySelector('.feather-eye-off');
            const eye = toggleButton.querySelector('.feather-eye');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOff.style.display = 'none';
                eye.style.display = 'block';
            } else {
                passwordInput.type = 'password';
                eyeOff.style.display = 'block';
                eye.style.display = 'none';
            }
        });
    });
});