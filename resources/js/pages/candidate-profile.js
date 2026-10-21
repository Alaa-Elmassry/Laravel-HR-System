const sidebarToggle = document.querySelector('[data-sidebar-toggle]');
const sidebarOverlay = document.querySelector('[data-sidebar-overlay]');
const currentRoleInput = document.querySelector('[data-current-role]');
const endDateInput = document.querySelector('[data-end-date]');
const resumeInput = document.querySelector('[data-resume-input]');
const resumeForm = document.querySelector('[data-resume-form]');

sidebarToggle?.addEventListener('click', () => {
    document.body.classList.toggle('sidebar-open');
});

sidebarOverlay?.addEventListener('click', () => {
    document.body.classList.remove('sidebar-open');
});

currentRoleInput?.addEventListener('change', () => {
    if (!endDateInput) {
        return;
    }

    endDateInput.disabled = currentRoleInput.checked;

    if (currentRoleInput.checked) {
        endDateInput.value = '';
    }
});

resumeInput?.addEventListener('change', () => {
    if (resumeInput.files?.length) {
        resumeForm?.requestSubmit();
    }
});
