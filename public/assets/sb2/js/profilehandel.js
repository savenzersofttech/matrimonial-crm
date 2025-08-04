$(document).ready(function () {
    // Reusable function to attach "Other" input logic
   function attachOtherInput(selectId, inputName, placeholderText) {
    const inputId = `${selectId}_other`;
    const inputHtml = `<input type="text" id="${inputId}" name="${inputName}" class="form-control mt-2 d-none" placeholder="${placeholderText}">`;

    // Insert after the select if not already added
    if (!$(`#${inputId}`).length) {
        $(`#${selectId}`).after(inputHtml);
    }

    $(`#${selectId}`).on('change', function () {
        const val = $(this).val(); // Can be string or array

        const shouldShow = Array.isArray(val)
            ? val.includes("0") || val.includes("Other")
            : val === "0" || val === "Other";

        $(`#${inputId}`).toggleClass('d-none', !shouldShow);
        if (!shouldShow) {
            $(`#${inputId}`).val('');
        }
    });
}


    // Attach to all required fields
    attachOtherInput('mother_tongue', 'mother_tongue_other', 'Enter Mother Tongue');
    attachOtherInput('health_status', 'health_status_other', 'Enter Health Status');
    attachOtherInput('religion', 'religion_other', 'Enter Religion');
    attachOtherInput('diet', 'diet_other', 'Enter Diet');
    attachOtherInput('body_type', 'body_type_other', 'Enter Type');
    attachOtherInput('profile_for', 'profile_for_other', 'Enter ');
    attachOtherInput('caste', 'caste_other', 'Enter Caste');
    attachOtherInput('highest_qualification', 'highest_qualification_other', 'Enter Qualification');
    attachOtherInput('education_field', 'education_field_other', 'Enter Education');
    attachOtherInput('employer_name', 'employer_name_other', 'Enter value');
    attachOtherInput('profession', 'profession_other', 'Enter value');
    attachOtherInput('father_occupation', 'father_occupation_other', 'Enter value');
    attachOtherInput('mother_occupation', 'mother_occupation_other', 'Enter value');

    //partner
    attachOtherInput('partner_religion', 'partner_religion_other', 'Enter Religion');
    attachOtherInput('partner_cast', 'partner_cast_other', 'Enter Religion');
    attachOtherInput('partner_diet', 'partner_diet_other', 'Enter Diet');
    attachOtherInput('partner_highest_qualification', 'partner_highest_qualification_other', 'Enter Qualification');
    attachOtherInput('partner_education_field', 'partner_education_field_other', 'Enter Education');
    attachOtherInput('partner_working_with', 'partner_working_with_other', 'Enter value');
    attachOtherInput('partner_profession', 'partner_profession_other', 'Enter value');

});




    const countrySelect = document.querySelector('#partner_country');
    const stateSelect = document.querySelector('#partner_state');
    const citySelect = document.querySelector('#partner_city');

    function setVirtualOptions(select, options) {
        if (select?.setOptions) {
            select.setOptions(options);
        } else {
            select.innerHTML = options.map(opt => `<option value="${opt.value}">${opt.label}</option>`).join('');
        }
    }

    // Load States on Country Change
        // Load States on Country Change
countrySelect.addEventListener('change', async function () {
    const selectedCountries = this.value; // Use VirtualSelect.getSelectedValues() if needed

    console.log('selectedCountries', selectedCountries);

    setVirtualOptions(stateSelect, []);
    setVirtualOptions(citySelect, []);

    if (!selectedCountries || selectedCountries.includes('Open to All')) {
        setVirtualOptions(stateSelect, [{ label: 'Open to All', value: 'Open to All' }]);
        return;
    }

    let allStates = [];

    // Use Promise.all to handle multiple API requests in parallel
    const stateRequests = selectedCountries.map(country => {
        return $.ajax({
            url: "https://countriesnow.space/api/v0.1/countries/states",
            method: "POST",
            contentType: "application/json",
            data: JSON.stringify({ country })
        }).then(res => {
            const states = res.data.states.map(s => ({
                label: `${s.name} (${country})`,
                value: s.name
            }));
            allStates = allStates.concat(states);
        }).catch(() => {
            console.warn(`Failed to fetch states for ${country}`);
        });
    });

    // Wait for all requests to complete
    await Promise.all(stateRequests);

    // Remove duplicates (optional)
    const uniqueStates = Array.from(
        new Map(allStates.map(state => [state.label, state])).values()
    );

    // Add "Open to All" option
    uniqueStates.push({ label: 'Open to All', value: 'Open to All' });

    setVirtualOptions(stateSelect, uniqueStates);
});


    // Load Cities on State Change
    // Load Cities on State Change
stateSelect.addEventListener('change', async function () {
    const selectedCountries = countrySelect.value; // Make sure this is an array (use VirtualSelect.getSelectedValues() if needed)
    const selectedStates = this.value;             // Also ensure this is an array

    setVirtualOptions(citySelect, []);

    if (!selectedCountries || !selectedStates || 
        selectedCountries.includes('Open to All') || selectedStates.includes('Open to All')) {
        setVirtualOptions(citySelect, [{ label: 'Open to All', value: 'Open to All' }]);
        return;
    }

    let allCities = [];

    const cityRequests = [];

    for (const country of selectedCountries) {
        for (const state of selectedStates) {
            cityRequests.push(
                $.ajax({
                    url: "https://countriesnow.space/api/v0.1/countries/state/cities",
                    method: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({ country, state })
                }).then(res => {
                    const cities = res.data.map(c => ({
                        label: `${c} (${state}, ${country})`,
                        value: c
                    }));
                    allCities = allCities.concat(cities);
                }).catch(() => {
                    console.warn(`Failed to fetch cities for ${state}, ${country}`);
                })
            );
        }
    }

    await Promise.all(cityRequests);

    // Remove duplicates
    const uniqueCities = Array.from(
        new Map(allCities.map(city => [city.label, city])).values()
    );

    // Add "Open to All" option
    uniqueCities.push({ label: 'Open to All', value: 'Open to All' });

    setVirtualOptions(citySelect, uniqueCities);
});

