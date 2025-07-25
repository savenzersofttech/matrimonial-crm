console.log('Form JS initialized');

// Retrieve CSRF token from meta tag
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

/**
 * Makes an HTTP request with enhanced form handling
 * @param {string} url - The endpoint URL
 * @param {string} method - HTTP method (GET or POST)
 * @param {FormData|Object} [data=null] - Form data or object to send
 * @param {Object} [customHeaders={}] - Optional custom headers
 * @returns {Promise<Object>} - JSON response or throws an error
 */
async function makeHttpRequest(url, method, data = null, customHeaders = {}) {
    try {
        // Default configuration
        const config = {
            method: method.toUpperCase(),
            headers: {
                'Accept': 'application/json',
                ...customHeaders
            }
        };

        // Add CSRF token for POST requests
        if (method.toUpperCase() === 'POST') {
            config.headers['X-CSRF-TOKEN'] = csrfToken;
            if (data instanceof FormData) {
                config.body = data;
            } else if (data) {
                config.headers['Content-Type'] = 'application/json';
                config.body = JSON.stringify(data);
            }
        } else if (method.toUpperCase() === 'GET' && data) {
            const params = new URLSearchParams(data).toString();
            url = `${url}${url.includes('?') ? '&' : '?'}${params}`;
        }

        // Make the HTTP request
        const res = await fetch(url, config);

        // Check if response is OK
        if (!res.ok) {
            const errorText = await res.text();
            console.error('HTTP Error:', res.status, res.statusText, errorText.slice(0, 100));
        }

        // Try to parse JSON response
        try {
            return await res.json();
        } catch (jsonError) {
            console.error('JSON Parse Error:', jsonError);
            throw new Error('Invalid JSON response from server');
        }
    } catch (error) {
        console.error('Request Failed:', error.message);
        throw error;
    }
}


/**
 * Collects all inputs from a form and returns FormData or an object
 * @param {HTMLFormElement} form - The form element
 * @param {boolean} [useFormData=true] - Whether to return FormData or an object
 * @returns {FormData|Object} - Form data
 */
function collectFormInputs(form, useFormData = true) {
    const formData = new FormData(form);
    if (useFormData) {
        return formData;
    }

    // Convert FormData to object if useFormData is false
    const data = {};
    formData.forEach((value, key) => {
        if (data[key]) {
            // Handle multiple values (e.g., checkboxes)
            if (!Array.isArray(data[key])) {
                data[key] = [data[key]];
            }
            data[key].push(value);
        } else {
            data[key] = value;
        }
    });
    return data;
}

/**
 * Handles form submission with HTTP request
 * @param {HTMLFormElement} form - The form element
 * @param {string} [method='POST'] - HTTP method
 * @param {Object} [customHeaders={}] - Optional custom headers
 * @param {boolean} [useFormData=true] - Whether to send FormData or JSON
 * @returns {Promise<Object>} - JSON response or throws an error
 */
async function submitForm(form, method = 'POST', customHeaders = {}, useFormData = true) {
    const url = form.action || window.location.href;
    const data = collectFormInputs(form, useFormData);

    try {
        const response = await makeHttpRequest(url, method, data, customHeaders);
        console.log('Form Submission Success:', response);
        return response;
    } catch (error) {
        console.error('Form Submission Failed:', error.message);
        throw error;
    }
}

// Example usage: Attach to form submit event
document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('form[data-ajax]');
    forms.forEach(form => {
        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            try {
                const response = await submitForm(form, form.method || 'POST');

                // Handle Laravel-style error response
                if (response.status === 'error') {
                    if (response.errors) {
                        const messages = Object.values(response.errors)
                            .flat()
                            .join('\n');
                        showDangerToast('Validation Failed', messages);
                    } else if (response.message) {
                        showDangerToast('Error', response.message);
                    } else {
                        showDangerToast('Error', 'Unknown server error.');
                    }
                    return;
                }

                // If success
                showSuccessToast("Done!", response.message || "Form submitted successfully.");
                $('#editModal').modal('hide');

            } catch (error) {
                // Catch and display lower-level errors (e.g., fetch failed, JSON parse error)
                showDangerToast("Request Failed", error.message || 'Something went wrong.');
            }
        });
    });
});
