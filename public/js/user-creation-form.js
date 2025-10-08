/**
 * Dynamic User Creation Form Handler
 * Handles switching between teacher and student forms based on user type selection
 */

class UserCreationForm {
    constructor() {
        this.currentUserType = 'operator';
        this.studentForm = null;
        this.init();
    }

    init() {
        this.bindEvents();
        this.setupFormElements();
        this.handleInitialState();
    }

    setupFormElements() {
        this.studentForm = document.getElementById('student-form-section');
        this.userTypeInputs = document.querySelectorAll('input[name="user_type"]');
        this.nameInput = document.getElementById('name');
        this.emailInput = document.getElementById('email');
        this.phoneInput = document.getElementById('phone');
    }

    bindEvents() {
        // User type change handler
        document.addEventListener('change', (e) => {
            if (e.target.name === 'user_type') {
                this.handleUserTypeChange(e.target.value);
            }
        });

        // Auto-populate name from teacher/student forms
        document.addEventListener('input', (e) => {
            if (e.target.id === 'student_full_name') {
                this.syncNameField(e.target.value);
            }
        });

        // Auto-populate phone from teacher mobile
        document.addEventListener('input', (e) => {
            if (e.target.id === 'student_mobile') {
                this.syncPhoneField(e.target.value);
            }
        });

        // Form submission handler
        document.getElementById('createUserForm').addEventListener('submit', (e) => {
            this.handleFormSubmission(e);
        });
    }

    handleInitialState() {
        // Check if any user type is already selected
        const selectedType = document.querySelector('input[name="user_type"]:checked');
        if (selectedType) {
            this.handleUserTypeChange(selectedType.value);
        }
    }

    handleUserTypeChange(userType) {
        this.currentUserType = userType;
        
        // Hide all specific forms first
        this.hideAllSpecificForms();
        
        // Show relevant form based on user type
        switch (userType) {
            case 'student':
                this.showStudentForm();
                break;
            case 'operator':
            default:
                // No additional form needed for operator
                break;
        }

        // Update form validation requirements
        this.updateValidationRequirements(userType);
        
        // Clear any previous data from hidden forms
        this.clearHiddenFormData(userType);
    }

    hideAllSpecificForms() {
        if (this.studentForm) {
            this.studentForm.classList.add('hidden');
        }
    }

    showStudentForm() {
        if (this.studentForm) {
            this.studentForm.classList.remove('hidden');
            // Add smooth animation
            this.studentForm.style.opacity = '0';
            setTimeout(() => {
                this.studentForm.style.transition = 'opacity 0.3s ease-in-out';
                this.studentForm.style.opacity = '1';
            }, 10);
        }
    }

    syncNameField(value) {
        if (this.nameInput && value.trim()) {
            this.nameInput.value = value.trim();
            this.nameInput.dispatchEvent(new Event('input', { bubbles: true }));
        }
    }

    syncPhoneField(value) {
        if (this.phoneInput && value.trim()) {
            this.phoneInput.value = value.trim();
            this.phoneInput.dispatchEvent(new Event('input', { bubbles: true }));
        }
    }

    updateValidationRequirements(userType) {
        // Remove existing validation classes
        this.clearValidationStates();

        if (userType === 'student') {
            this.setStudentValidation();
        }
    }

    setStudentValidation() {
        const requiredFields = [
            'student_full_name',
            'student_date_of_birth',
            'student_gender'
        ];

        requiredFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field) {
                field.setAttribute('required', 'required');
                field.classList.add('required-field');
            }
        });
    }

    clearValidationStates() {
        // Remove required attributes from all teacher/student fields
        const allFields = document.querySelectorAll('[id^="student_"]');
        allFields.forEach(field => {
            field.removeAttribute('required');
            field.classList.remove('required-field');
        });
    }

    clearHiddenFormData(activeUserType) {
        if (activeUserType !== 'student') {
            this.clearFormSection('student');
        }
    }

    clearFormSection(section) {
        const fields = document.querySelectorAll(`[id^="${section}_"]`);
        fields.forEach(field => {
            if (field.type === 'checkbox' || field.type === 'radio') {
                field.checked = false;
            } else {
                field.value = '';
            }
        });
    }

    handleFormSubmission(e) {
        e.preventDefault();

        // Validate based on current user type
        if (!this.validateCurrentForm()) {
            return false;
        }

        // Show loading state
        this.showLoadingState();

        // Prepare form data
        const formData = new FormData(e.target);
        
        // Add user type to form data
        formData.set('user_type', this.currentUserType);

        // Submit form via AJAX
        this.submitForm(formData);
    }

    validateCurrentForm() {
        let isValid = true;
        const errors = [];

        // Validate base fields
        if (!this.nameInput.value.trim()) {
            errors.push('Full name is required');
            this.showFieldError(this.nameInput, 'Full name is required');
            isValid = false;
        }

        if (!this.emailInput.value.trim()) {
            errors.push('Email is required');
            this.showFieldError(this.emailInput, 'Email is required');
            isValid = false;
        }

        if (!this.phoneInput.value.trim()) {
            errors.push('Phone is required');
            this.showFieldError(this.phoneInput, 'Phone is required');
            isValid = false;
        }

        // Validate password
        const password = document.getElementById('password');
        const passwordConfirm = document.getElementById('password_confirmation');
        
        if (!password.value) {
            errors.push('Password is required');
            this.showFieldError(password, 'Password is required');
            isValid = false;
        } else if (password.value !== passwordConfirm.value) {
            errors.push('Password confirmation does not match');
            this.showFieldError(passwordConfirm, 'Password confirmation does not match');
            isValid = false;
        }

        // Validate specific form sections
        if (this.currentUserType === 'student') {
            isValid = this.validateStudentForm() && isValid;
        }

        return isValid;
    }

    validateStudentForm() {
        let isValid = true;
        const requiredFields = [
            { id: 'student_full_name', name: 'Student full name' },
            { id: 'student_date_of_birth', name: 'Date of birth' },
            { id: 'student_gender', name: 'Gender' }
        ];

        requiredFields.forEach(field => {
            const element = document.getElementById(field.id);
            if (element && !element.value.trim()) {
                this.showFieldError(element, `${field.name} is required`);
                isValid = false;
            }
        });

        return isValid;
    }

    showFieldError(field, message) {
        // Remove existing error
        this.clearFieldError(field);

        // Add error styling
        field.classList.add('border-red-500');
        field.classList.remove('border-gray-300', 'dark:border-gray-600');

        // Add error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'text-red-600 text-sm mt-1 field-error';
        errorDiv.textContent = message;
        field.parentNode.appendChild(errorDiv);
    }

    clearFieldError(field) {
        // Remove error styling
        field.classList.remove('border-red-500');
        field.classList.add('border-gray-300', 'dark:border-gray-600');

        // Remove error message
        const errorDiv = field.parentNode.querySelector('.field-error');
        if (errorDiv) {
            errorDiv.remove();
        }
    }

    clearAllErrors() {
        document.querySelectorAll('.field-error').forEach(error => error.remove());
        document.querySelectorAll('.border-red-500').forEach(field => {
            field.classList.remove('border-red-500');
            field.classList.add('border-gray-300', 'dark:border-gray-600');
        });
    }

    showLoadingState() {
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const submitIcon = document.getElementById('submitIcon');

        if (submitBtn) {
            submitBtn.disabled = true;
            if (submitText) submitText.textContent = 'Creating...';
            if (submitIcon) {
                submitIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>';
            }
        }
    }

    resetLoadingState() {
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const submitIcon = document.getElementById('submitIcon');

        if (submitBtn) {
            submitBtn.disabled = false;
            if (submitText) submitText.textContent = 'Create User';
            if (submitIcon) {
                submitIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>';
            }
        }
    }

    async submitForm(formData) {
        try {
            const response = await fetch(document.getElementById('createUserForm').action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();
            this.resetLoadingState();

            if (data.success) {
                this.showSuccessMessage(data.message || 'User created successfully!');
                setTimeout(() => {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                }, 1500);
            } else {
                this.handleFormErrors(data);
            }
        } catch (error) {
            this.resetLoadingState();
            console.error('Form submission error:', error);
            this.showErrorMessage('An unexpected error occurred. Please try again.');
        }
    }

    handleFormErrors(data) {
        if (data.errors) {
            // Handle validation errors
            for (const [field, messages] of Object.entries(data.errors)) {
                const fieldElement = document.querySelector(`[name="${field}"]`);
                if (fieldElement) {
                    this.showFieldError(fieldElement, messages[0]);
                }
            }
        } else {
            this.showErrorMessage(data.message || 'Failed to create user');
        }
    }

    showSuccessMessage(message) {
        this.showNotification(message, 'success');
    }

    showErrorMessage(message) {
        this.showNotification(message, 'error');
    }

    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-green-100 border-green-400 text-green-700' : 
                       type === 'error' ? 'bg-red-100 border-red-400 text-red-700' : 
                       'bg-blue-100 border-blue-400 text-blue-700';
        
        notification.className = `fixed top-4 right-4 ${bgColor} px-4 py-3 rounded-lg shadow-lg z-50 border`;
        notification.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    ${type === 'success' ? 
                        '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>' :
                        '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>'
                    }
                </svg>
                <span>${message}</span>
            </div>
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.remove();
        }, type === 'success' ? 3000 : 5000);
    }
}

// Initialize the form handler when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new UserCreationForm();
});
