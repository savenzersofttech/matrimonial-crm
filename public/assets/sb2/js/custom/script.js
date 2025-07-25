document.addEventListener("DOMContentLoaded", function () {
    const phoneInput = document.querySelector("#phone");
    const phoneCodeInput = document.querySelector("#phone_code");

    if (!phoneInput || !phoneCodeInput) return;

    const iti = window.intlTelInput(phoneInput, {
        initialCountry: "in", // or "auto"
        separateDialCode: true,
        preferredCountries: ["in", "us", "gb", "ca"],
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"
    });

    // Function to update hidden input
    const updatePhoneCode = () => {
        const dialCode = iti.getSelectedCountryData().dialCode;
        phoneCodeInput.value = `+${dialCode}`;
    };

    // Initial set
    updatePhoneCode();

    // Update on country change
    phoneInput.addEventListener("countrychange", updatePhoneCode);
});

function getStatusClass(status) {
    switch ((status || '').toLowerCase()) {
        case 'interested':
            return 'success';
        case 'follow-up needed':
            return 'warning';
        case 'no response':
            return 'danger';
        case 'not interested':
            return 'secondary';
        default:
            return 'light';
    }
}
