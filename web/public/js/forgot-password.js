/**
 * Forgot Password Form Handler
 * Handles form validation, submission, and UI states for the forgot password page
 */

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('reset-password-form');
    const emailInput = document.getElementById('reset-email');
    const submitBtn = document.getElementById('reset-submit-btn');
    const btnText = document.getElementById('btn-text');
    const btnSpinner = document.getElementById('btn-spinner');
    const emailError = document.getElementById('email-error');
    const formContainer = document.getElementById('forgot-password-form');
    const successMessage = document.getElementById('success-message');

    // Email validation regex
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    /**
     * Validates email format
     * @param {string} email - Email address to validate
     * @returns {boolean} - True if valid, false otherwise
     */
    function isValidEmail(email) {
        return emailRegex.test(email.trim());
    }

    /**
     * Shows error message for email field
     * @param {string} message - Error message to display
     */
    function showEmailError(message) {
        emailError.textContent = message;
        emailError.style.display = 'block';
        emailInput.classList.add('cs_input_error');
        emailInput.classList.remove('cs_input_success');
    }

    /**
     * Hides email error message
     */
    function hideEmailError() {
        emailError.style.display = 'none';
        emailInput.classList.remove('cs_input_error');
        emailInput.classList.add('cs_input_success');
    }

    /**
     * Shows loading state on submit button
     */
    function showLoadingState() {
        submitBtn.disabled = true;
        btnText.style.display = 'none';
        btnSpinner.style.display = 'inline-flex';
        emailInput.disabled = true;
    }

    /**
     * Hides loading state on submit button
     */
    function hideLoadingState() {
        submitBtn.disabled = false;
        btnText.style.display = 'inline';
        btnSpinner.style.display = 'none';
        emailInput.disabled = false;
    }

    /**
     * Shows success message and hides form
     */
    function showSuccessMessage() {
        formContainer.style.display = 'none';
        successMessage.style.display = 'block';
    }

    /**
     * Simulates API call to reset password
     * @param {string} email - Email address for password reset
     * @returns {Promise} - Promise that resolves with success/error
     */
    function resetPassword(email) {
        return new Promise((resolve, reject) => {
            // Simulate API delay
            setTimeout(() => {
                // Simulate success for demo purposes
                // In a real implementation, this would be an actual API call
                const success = Math.random() > 0.1; // 90% success rate for demo

                if (success) {
                    resolve({ success: true, message: 'Reset link sent successfully' });
                } else {
                    reject({ success: false, message: 'Failed to send reset link. Please try again.' });
                }
            }, 2000); // 2 second delay to simulate network request
        });
    }

    /**
     * Handles real-time email validation
     */
    emailInput.addEventListener('input', function() {
        const email = this.value.trim();

        if (email === '') {
            // Hide error if field is empty
            emailError.style.display = 'none';
            emailInput.classList.remove('cs_input_error', 'cs_input_success');
        } else if (isValidEmail(email)) {
            hideEmailError();
        } else {
            showEmailError('Please enter a valid email address');
        }
    });

    /**
     * Handles form submission
     */
    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const email = emailInput.value.trim();

        // Validate email before submission
        if (!email) {
            showEmailError('Email address is required');
            emailInput.focus();
            return;
        }

        if (!isValidEmail(email)) {
            showEmailError('Please enter a valid email address');
            emailInput.focus();
            return;
        }

        // Clear any existing errors
        hideEmailError();

        // Show loading state
        showLoadingState();

        try {
            // Attempt password reset
            const result = await resetPassword(email);

            if (result.success) {
                showSuccessMessage();
            }
        } catch (error) {
            // Hide loading state
            hideLoadingState();

            // Show error message
            showEmailError(error.message || 'An error occurred. Please try again.');

            // Focus on email input
            emailInput.focus();
        }
    });

    /**
     * Handles keyboard navigation and accessibility
     */
    emailInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            form.dispatchEvent(new Event('submit'));
        }
    });

    /**
     * Clear errors when user starts typing after an error
     */
    emailInput.addEventListener('focus', function() {
        if (emailError.style.display === 'block') {
            hideEmailError();
        }
    });
});
