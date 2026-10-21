const reviewedDocuments = document.querySelector('[data-reviewed-documents]');
const acceptOfferButton = document.querySelector('[data-accept-offer]');

const syncAcceptButton = () => {
    if (acceptOfferButton) {
        acceptOfferButton.disabled = !reviewedDocuments?.checked;
    }
};

reviewedDocuments?.addEventListener('change', syncAcceptButton);
syncAcceptButton();
