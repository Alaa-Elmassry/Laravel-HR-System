const preferencesForm = document.querySelector('[data-preferences-form]');
const cancelPreferences = document.querySelector('[data-cancel-preferences]');
const preferenceActions = cancelPreferences?.closest('.preferences-actions');

preferencesForm?.addEventListener('input', () => {
    preferenceActions?.classList.add('is-dirty');
});

cancelPreferences?.addEventListener('click', () => {
    preferencesForm?.reset();
    preferenceActions?.classList.remove('is-dirty');
    window.scrollTo({ top: 0, behavior: 'smooth' });
});
