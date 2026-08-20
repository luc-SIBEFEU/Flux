function initForm() {
    if (window.__fluxAdminFormInitialized) return;
    window.__fluxAdminFormInitialized = true;

    const form = document.getElementById('form');
    const overlay = document.getElementById('form-overlay');
    const openButtons = document.querySelectorAll('.js-form-open-toggle');
    const closeButtons = document.querySelectorAll('.js-form-close-toggle');

    if (!form || !overlay || !openButtons.length) return;

    const setFormState = (isOpen) => {
        form.classList.toggle('is-open', isOpen);
        form.classList.toggle('hidden', !isOpen);
        overlay.classList.toggle('is-visible', isOpen);
        overlay.classList.toggle('hidden', !isOpen);

        openButtons.forEach((button) => {
            button.classList.toggle('hidden', isOpen);
        });

        closeButtons.forEach((button) => {
            button.classList.toggle('hidden', !isOpen);
        });
    };

    openButtons.forEach((button) => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            const isOpen = form.classList.contains('is-open');
            setFormState(!isOpen);
        });
    });

    closeButtons.forEach((button) => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            setFormState(false);
        });
    });

    overlay.addEventListener('click', () => setFormState(false));

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && form.classList.contains('is-open')) {
            setFormState(false);
        }
    });

    setFormState(false);
}

document.addEventListener('DOMContentLoaded', initForm);