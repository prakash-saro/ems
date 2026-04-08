function clearError(input) {
    if (!input) return;

    input.classList.remove('is-invalid');

    let error = input.closest('.mb-3')?.querySelector('.invalid-feedback');

    if (error) {
        error.style.display = 'none';
    }
}

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('input', function () {
            clearError(this);
        });
    });
});