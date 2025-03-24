document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.getElementById("loginForm");
    const registerForm = document.getElementById("registerForm");

    if (loginForm) {
        loginForm.addEventListener("submit", function (event) {
            event.preventDefault();
            if (validateLogin()) {
                let messageDiv = document.getElementById("loginMessage");
                fetch("../controllers/AuthController.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: new URLSearchParams({
                        action: "login",
                        email: email.value.trim(),
                        password: password.value.trim()
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        messageDiv.innerHTML = data.success;
                        messageDiv.style.color = "green";
                        setTimeout(() => {
                            window.location.href = "../views/dashboard.php";
                        }, 1000);
                    } else {
                        messageDiv.innerHTML = data.error;
                        messageDiv.style.color = "red";
                    }
                })
                .catch(error => console.error("Error:", error));
            }
        });
    }

    if (registerForm) {
        registerForm.addEventListener("submit", function (event) {
            event.preventDefault();
            if (validateRegister()) {
                let messageDiv = document.getElementById("registerMessage");
                const image = document.getElementById("profile_image").files[0];
                let formData = new FormData();

                formData.append("action", "register");
                formData.append("username", username.value.trim());
                formData.append("email", email.value.trim());
                formData.append("password", password.value.trim());
                formData.append("profile_image", image);

                fetch("../controllers/AuthController.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    messageDiv.innerHTML = data.success ? data.success : data.error;
                    messageDiv.style.color = data.success ? "green" : "red";
                })
                .catch(error => console.error("Error:", error));
            }
        });
    }
});

// Validate Register Form
function validateRegister() {
    let valid = true;
    const username = document.getElementById('username');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    const image = document.getElementById("profile_image").files[0];

    clearErrors();

    if (!/^[a-zA-Z0-9]{3,20}$/.test(username.value.trim())) {
        showError(username, 'Username must be 3-20 characters long and contain only letters, numbers.');
        valid = false;
    }

    if (!validateEmail(email.value.trim())) {
        showError(email, 'Enter a valid email.');
        valid = false;
    }

    if (password.value.trim().length < 8 || !/[A-Z]/.test(password.value.trim()) || !/[0-9]/.test(password.value.trim())) {
        showError(password, 'Password must be at least 8 characters long, contain one uppercase letter, and one number.');
        valid = false;
    }

    if (password.value.trim() !== confirmPassword.value.trim()) {
        showError(confirmPassword, 'Passwords do not match.');
        valid = false;
    }

    if (image) {
        const allowedExtensions = ["image/jpeg", "image/png", "image/jpg"];
        if (!allowedExtensions.includes(image.type)) {
            showError(image, 'Only JPG, JPEG, and PNG files are allowed.');
            valid = false;
        }
        if (image.size > 2 * 1024 * 1024) {
            showError(image, 'Image size must be less than 2MB.');
            valid = false;
        }
    } else {
        showError(image, 'Profile image is required.');
        valid = false;
    }

    return valid;
}

// Validate Login Form
function validateLogin() {
    let valid = true;
    const email = document.getElementById('email');
    const password = document.getElementById('password');

    clearErrors();

    if (!validateEmail(email.value.trim())) {
        showError(email, 'Enter a valid email.');
        valid = false;
    }

    if (password.value.trim() === '') {
        showError(password, 'Password is required.');
        valid = false;
    }

    return valid;
}

// Helper Functions
function showError(input, message) {
    const errorMessage = input.nextElementSibling;
    errorMessage.textContent = message;
    input.style.borderColor = "red";
}

function clearErrors() {
    document.querySelectorAll('.error-message').forEach((el) => el.textContent = "");
    document.querySelectorAll('input').forEach((el) => el.style.borderColor = "#ccc");
}

function validateEmail(email) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
}
