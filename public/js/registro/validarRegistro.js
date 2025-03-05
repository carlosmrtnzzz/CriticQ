class FormValidator {
    constructor(form) {
        this.form = form;
        this.errors = [];
        this.initEventListeners();
    }

    initEventListeners() {
        this.form.addEventListener('submit', (e) => {
            this.errors = [];
            this.validateForm(e);
        });

        const inputs = this.form.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('input', () => {
                this.validateInput(input);
            });
        });
    }

    validateInput(input) {
        switch (input.name) {
            case 'username':
                if (this.validateUsername(input.value)) {
                    this.removeError(input);
                }
                break;
            case 'nombre':
            case 'apellido':
                if (this.validateName(input.value)) {
                    this.removeError(input);
                }
                break;
            case 'email':
                if (this.validateEmail(input.value)) {
                    this.removeError(input);
                }
                break;
            case 'password':
                console.log('Validating password:', input.value);
                console.log('Is valid:', this.validatePassword(input.value));
                if (this.validatePassword(input.value)) {
                    this.removeError(input);
                }
                break;
            case 'password_confirmation':
                const passwordInput = this.form.querySelector('input[name="password"]');
                if (input.value === passwordInput.value) {
                    this.removeError(input);
                }
                break;
        }
    }

    validateForm(e) {
        const username = this.form.querySelector('input[name="username"]');
        const nombre = this.form.querySelector('input[name="nombre"]');
        const apellido = this.form.querySelector('input[name="apellido"]');
        const email = this.form.querySelector('input[name="email"]');
        const password = this.form.querySelector('input[name="password"]');
        const passwordConfirmation = this.form.querySelector('input[name="password_confirmation"]');
        const avatar = this.form.querySelector('input[name="avatar"]');

        if (!this.validateUsername(username.value)) {
            this.addError(username, 'El nombre de usuario debe tener entre 5 y 15 caracteres, solo letras, números y guiones bajos');
            e.preventDefault();
        }

        if (!this.validateName(nombre.value)) {
            this.addError(nombre, 'El nombre debe contener solo letras y tener entre 2 y 20 caracteres');
            e.preventDefault();
        }

        if (!this.validateName(apellido.value)) {
            this.addError(apellido, 'El apellido debe contener solo letras y tener entre 2 y 20 caracteres');
            e.preventDefault();
        }

        if (!this.validateEmail(email.value)) {
            this.addError(email, 'Por favor ingrese un correo electrónico válido');
            e.preventDefault();
        }

        if (!this.validatePassword(password.value)) {
            this.addError(password, 'La contraseña debe tener mínimo 8 caracteres, incluyendo una mayúscula, una minúscula y un número');
            e.preventDefault();
        }

        if (password.value !== passwordConfirmation.value) {
            this.addError(passwordConfirmation, 'Las contraseñas no coinciden');
            e.preventDefault();
        }

        if (avatar.files.length > 0 && !this.validateAvatar(avatar.files[0])) {
            this.addError(avatar, 'El archivo debe ser una imagen (jpg, jpeg, png, gif) con un tamaño máximo de 5MB');
            e.preventDefault();
        }

        this.displayErrors();
    }

    validateUsername(username) {
        const usernameRegex = /^[a-zA-Z0-9_]{5,15}$/;
        return usernameRegex.test(username);
    }

    validateName(name) {
        const nameRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{2,20}$/;
        return nameRegex.test(name);
    }

    validateEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    validatePassword(password) {
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
        return passwordRegex.test(password);
    }

    validateAvatar(file) {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        const maxSize = 5 * 1024 * 1024;

        return allowedTypes.includes(file.type) && file.size <= maxSize;
    }

    addError(element, message) {
        this.removeError(element);

        this.errors.push({ element, message });
        element.classList.add('is-invalid');
    }

    removeError(element) {
        const existingError = element.parentNode.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }

        element.classList.remove('is-invalid');

        this.errors = this.errors.filter(error => error.element !== element);
    }

    displayErrors() {
        this.errors.forEach(({ element, message }) => {
            const errorDiv = document.createElement('div');
            errorDiv.classList.add('error-message');
            errorDiv.textContent = message;
            element.parentNode.insertBefore(errorDiv, element.nextSibling);
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    new FormValidator(form);
});