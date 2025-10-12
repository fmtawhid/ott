// ==========================
// Password toggle handlers
// ==========================
const togglePasswordVisibility = (toggleId, inputId) => {
    const toggle = document.querySelector(`#${toggleId}`);
    const input = document.querySelector(`#${inputId}`);
    if (toggle && input) {
        toggle.addEventListener('click', function () {
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    }
};

togglePasswordVisibility('togglePassword', 'password');
togglePasswordVisibility('toggleConfirmPassword', 'confirm_password');

// ==========================
// Helpers
// ==========================
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function showValidationError(input, message) {
    const container = input.closest('.input-group');
    const errorFeedback = container.querySelector('.invalid-feedback');
    if (errorFeedback) {
        errorFeedback.textContent = message;
        input.classList.add('is-invalid');
    }
}

function clearValidationError(input) {
    const container = input.closest('.input-group');
    const errorFeedback = container.querySelector('.invalid-feedback');
    if (errorFeedback) {
        errorFeedback.textContent = '';
        input.classList.remove('is-invalid');
    }
}

function toggleButton(isSubmitting, button, submittingText, defaultText) {
    button.textContent = isSubmitting ? submittingText : defaultText;
    button.disabled = isSubmitting;
}

function attachLiveInputClear(form, fields) {
    fields.forEach(fieldName => {
        const input = form.querySelector(`input[name="${fieldName}"]`);
        if (input) {
            input.addEventListener('input', () => clearValidationError(input));
        }
    });
}

// ==========================
// Register Form
// ==========================
const registerForm = document.querySelector('#registerForm');
if (registerForm) {
    const registerButton = document.querySelector('#register-button');
    const errorMessage = document.querySelector('#error_message');
    const baseUrl = document.querySelector('meta[name="base-url"]').getAttribute('content');

    const firstNameInput = registerForm.querySelector('input[name="first_name"]');
    const lastNameInput = registerForm.querySelector('input[name="last_name"]');

    // Prevent numbers in first name and last name + immediate error + auto-remove numbers
    [firstNameInput, lastNameInput].forEach(input => {
        input.addEventListener('input', () => {
            const numberPattern = /[0-9]/g;
            if (numberPattern.test(input.value)) {
                input.value = input.value.replace(numberPattern, '');
                showValidationError(input, 'Name field does not allow numbers.');
            } else if (!input.value.trim()) {
                showValidationError(input, 'This field is required.');
            } else {
                clearValidationError(input);
            }
        });
    });

    attachLiveInputClear(registerForm, ['first_name', 'last_name', 'email', 'password', 'confirm_password']);

    registerForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        if (!validateRegisterForm()) return;

        toggleButton(true, registerButton, 'Signing Up...', 'Sign Up');
        errorMessage.textContent = '';

        try {
            const formData = new FormData(this);
            const response = await fetch(`${baseUrl}/api/register?is_ajax=1`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            const data = await response.json();

            if (!response.ok || !data.status) {
                const message = data.errors ? Object.values(data.errors).flat()[0] : data.message || 'An error occurred during registration';
                errorMessage.textContent = message;
                return;
            }

            // Auto-login after registration
            const loginResponse = await fetch(`${baseUrl}/api/login?is_ajax=1`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            const loginData = await loginResponse.json();
            if (loginData.status === true) {
                window.location.href = `${baseUrl}`;
            } else {
                errorMessage.textContent = loginData.message || 'Login after registration failed.';
            }

        } catch (error) {
            console.error('Registration error:', error);
            errorMessage.textContent = 'A system error occurred. Please try again later.';
        } finally {
            toggleButton(false, registerButton, '', 'Sign Up');
        }
    });

    function validateRegisterForm() {
        let isValid = true;
        const firstName = registerForm.querySelector('input[name="first_name"]');
        const lastName = registerForm.querySelector('input[name="last_name"]');
        const email = registerForm.querySelector('input[name="email"]');
        const password = registerForm.querySelector('input[name="password"]');
        const confirmPassword = registerForm.querySelector('input[name="confirm_password"]');

        if (!firstName.value.trim()) {
            showValidationError(firstName, 'First Name field is required.');
            isValid = false;
        }

        if (!lastName.value.trim()) {
            showValidationError(lastName, 'Last Name field is required.');
            isValid = false;
        }

        if (!email.value.trim()) {
            showValidationError(email, 'Email field is required.');
            isValid = false;
        } else if (!validateEmail(email.value)) {
            showValidationError(email, 'Enter a valid Email Address.');
            isValid = false;
        }

        if (!password.value.trim()) {
            showValidationError(password, 'Password field is required.');
            isValid = false;
        } else if (password.value.length < 8) {
            showValidationError(password, 'Password must be at least 8 characters long.');
            isValid = false;
        }

        if (password.value !== confirmPassword.value) {
            showValidationError(confirmPassword, 'Passwords and confirm password do not match.');
            isValid = false;
        }

        return isValid;
    }
}

// ==========================
// Login Form
// ==========================
const loginForm = document.querySelector('#login-form');
if (loginForm) {
    const loginButton = document.querySelector('#login-button');
    const loginError = document.querySelector('#login_error_message');
    const baseUrl = document.querySelector('meta[name="base-url"]').getAttribute('content');

    attachLiveInputClear(loginForm, ['email', 'password']);

    loginForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        if (!validateLoginForm()) return;

        toggleButton(true, loginButton, 'Signing In...', 'Sign In');
        loginError.textContent = '';

        try {
            const formData = new FormData(this);
            const response = await fetch(`${baseUrl}/api/login?is_ajax=1`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            const data = await response.json();

            if (!response.ok || !data.status) {
                const message = data.errors ? Object.values(data.errors).flat()[0] : data.message || 'Login failed';
                loginError.textContent = message;
                return;
            }

            if (data.device_limit_reached) {
                loginError.textContent = "Your device limit has been reached.";
                return;
            }

            window.location.href = `${baseUrl}`;
        } catch (error) {
            console.error('Login error:', error);
            loginError.textContent = 'A system error occurred. Please try again later.';
        } finally {
            toggleButton(false, loginButton, '', 'Sign In');
        }
    });

    function validateLoginForm() {
        let isValid = true;
        const email = loginForm.querySelector('input[name="email"]');
        const password = loginForm.querySelector('input[name="password"]');

        if (!email.value.trim()) {
            showValidationError(email, 'Email field is required.');
            isValid = false;
        } else if (!validateEmail(email.value)) {
            showValidationError(email, 'Enter a valid Email Address.');
            isValid = false;
        }

        if (!password.value.trim()) {
            showValidationError(password, 'Password field is required.');
            isValid = false;
        }

        return isValid;
    }
}

// ==========================
// Forgot Password Form
// ==========================
const forgetPasswordForm = document.querySelector('#forgetpassword-form');
if (forgetPasswordForm) {
    const forgetPasswordButton = document.querySelector('#forget_password_btn');
    const forgetPasswordError = document.querySelector('#forgetpassword_error_message');
    const forgetPasswordMessage = document.querySelector('#forget_password_msg');
    const baseUrl = document.querySelector('meta[name="base-url"]').getAttribute('content');

    attachLiveInputClear(forgetPasswordForm, ['email']);

    forgetPasswordForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        if (!validateForgetPasswordForm()) return;

        toggleButton(true, forgetPasswordButton, 'Sending...', 'Submit');
        forgetPasswordError.textContent = '';
        forgetPasswordMessage.classList.add('d-none');

        try {
            const formData = new FormData(this);
            const response = await fetch(`${baseUrl}/api/forgot-password?is_ajax=1`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            const data = await response.json();

            if (!response.ok || !data.status) {
                const message = data.errors ? Object.values(data.errors).flat()[0] : data.message || 'Password reset failed';
                forgetPasswordError.textContent = message;
                return;
            }

            forgetPasswordMessage.classList.remove('d-none');
            forgetPasswordForm.reset();
        } catch (error) {
            console.error('Forgot password error:', error);
            forgetPasswordError.textContent = 'A system error occurred. Please try again later.';
        } finally {
            toggleButton(false, forgetPasswordButton, '', 'Submit');
        }
    });

    function validateForgetPasswordForm() {
        let isValid = true;
        const email = forgetPasswordForm.querySelector('input[name="email"]');

        if (!email.value.trim()) {
            showValidationError(email, 'Email field is required.');
            isValid = false;
        } else if (!validateEmail(email.value)) {
            showValidationError(email, 'Enter a valid Email Address.');
            isValid = false;
        }

        return isValid;
    }
}
