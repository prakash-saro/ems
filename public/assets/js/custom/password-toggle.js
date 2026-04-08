function togglePassword(checkbox, inputId) {
    const passwordInput = document.getElementById(inputId);

    if (!passwordInput) return;

    passwordInput.type = checkbox.checked ? "text" : "password";
}
