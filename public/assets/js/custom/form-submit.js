function disableSubmitButton(formId, btnId, btnTextId, spinnerId, loadingText = 'Submitting...') {
    const form = document.getElementById(formId);
    const btn = document.getElementById(btnId);
    const btnText = document.getElementById(btnTextId);
    const spinner = document.getElementById(spinnerId);

    if (form) {
        form.addEventListener('submit', function () {
            if (btn) btn.disabled = true;
            if (btnText) btnText.textContent = loadingText;
            if (spinner) spinner.classList.remove('d-none');
        });
    }
}
