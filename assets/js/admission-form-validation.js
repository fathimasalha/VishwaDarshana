// Complete validation script with all functionality

let currentSection = 1;
const totalSections = 5;

// Subject combinations based on course
const subjectCombinations = {
    'Science': [
        { value: 'PCMB', text: 'Physics, Chemistry, Mathematics, Biology' },
        { value: 'PCMC', text: 'Physics, Chemistry, Mathematics, Computer Science' },
        { value: 'PCME', text: 'Physics, Chemistry, Mathematics, Electronics' },
        { value: 'PCMS', text: 'Physics, Chemistry, Mathematics, Statistics' }
    ],
    'Commerce': [
        { value: 'BASM', text: 'Business Studies, Accountancy, Statistics, Mathematics' },
        { value: 'BASE', text: 'Business Studies, Accountancy, Statistics, Economics' },
        { value: 'BASC', text: 'Business Studies, Accountancy, Statistics, Computer Science' },
        { value: 'BASP', text: 'Business Studies, Accountancy, Statistics, Psychology' }
    ]
};

// Validation patterns
const validationPatterns = {
    alphabetsOnly: /^[a-zA-Z\s]+$/,
    numbersOnly: /^[0-9]+$/,
    indianMobile: /^[6-9]\d{9}$/,
    pinCode: /^\d{6}$/,
    aadharFormat: /^\d{4}\s\d{4}\s\d{4}$/,
    dateFormat: /^\d{2}-\d{2}-\d{4}$/,
    email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/
};

// Update subject combinations based on course selection
function updateSubjectCombinations() {
    const course = document.getElementById('sa_course').value;
    const subjectSelect = document.getElementById('sa_subject_combination');
    
    // Clear existing options
    subjectSelect.innerHTML = '<option value="">Select Subject Combination</option>';
    subjectSelect.disabled = true;
    
    if (course && subjectCombinations[course]) {
        subjectCombinations[course].forEach(combo => {
            const option = document.createElement('option');
            option.value = combo.value;
            option.textContent = combo.text;
            subjectSelect.appendChild(option);
        });
        subjectSelect.disabled = false;
    }
}

// Navigation functions
function nextSection() {
    if (validateCurrentSection()) {
        if (currentSection < totalSections) {
            // Update progress
            const currentStep = document.querySelector(`.vd-form-progress-step[data-step="${currentSection}"]`);
            if (currentStep) {
                currentStep.classList.add('completed');
                currentStep.classList.remove('active');
            }
            
            currentSection++;
            
            const nextStep = document.querySelector(`.vd-form-progress-step[data-step="${currentSection}"]`);
            if (nextStep) {
                nextStep.classList.add('active');
            }
            
            // Show next section
            showSection(currentSection);
            
            // If moving to review section, populate review content
            if (currentSection === 5) {
                populateReview();
            }
        }
    }
}

function previousSection() {
    if (currentSection > 1) {
        const currentStep = document.querySelector(`.vd-form-progress-step[data-step="${currentSection}"]`);
        if (currentStep) {
            currentStep.classList.remove('active');
        }
        
        currentSection--;
        
        const prevStep = document.querySelector(`.vd-form-progress-step[data-step="${currentSection}"]`);
        if (prevStep) {
            prevStep.classList.add('active');
            prevStep.classList.remove('completed');
        }
        
        showSection(currentSection);
    }
}

function showSection(sectionNumber) {
    // Hide all sections
    document.querySelectorAll('.vd-form-section').forEach(section => {
        section.classList.remove('active');
    });
    
    // Show current section
    const targetSection = document.querySelector(`.vd-form-section[data-section="${sectionNumber}"]`);
    if (targetSection) {
        targetSection.classList.add('active');
    }
    
    // Scroll to top
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Validation functions
function validateCurrentSection() {
    const currentFormSection = document.querySelector(`.vd-form-section[data-section="${currentSection}"]`);
    if (!currentFormSection) return false;
    
    const requiredFields = currentFormSection.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!validateField(field)) {
            isValid = false;
        }
    });
    
    // Special validation for section 4 (payment)
    if (currentSection === 4) {
        const termsCheckbox = document.getElementById('terms_accepted');
        if (termsCheckbox && !termsCheckbox.checked) {
            showFieldError(termsCheckbox, 'You must accept the terms and conditions');
            isValid = false;
        }
    }
    
    if (!isValid) {
        showAlert('Please fill all required fields correctly.', 'error');
    }
    
    return isValid;
}

function validateField(field) {
    const value = field.value.trim();
    const errorSpan = field.parentElement.querySelector('.vd-form-error-message');
    
    // Clear previous error
    field.classList.remove('error');
    if (errorSpan) errorSpan.textContent = '';
    
    // Check if required field is empty
    if (field.hasAttribute('required') && (!value && field.type !== 'checkbox' && field.type !== 'file')) {
        showFieldError(field, 'This field is required');
        return false;
    }
    
    // Checkbox validation
    if (field.type === 'checkbox' && field.hasAttribute('required') && !field.checked) {
        showFieldError(field, 'This field is required');
        return false;
    }
    
    // File validation
    if (field.type === 'file' && field.hasAttribute('required') && field.files.length === 0) {
        showFieldError(field, 'Please upload a file');
        return false;
    }
    
    // Specific validations
    switch (field.id) {
        case 'sa_name':
        case 'sa_mother_name':
        case 'sa_father_name':
            if (value && !validationPatterns.alphabetsOnly.test(value)) {
                showFieldError(field, 'Only alphabets and spaces are allowed');
                return false;
            }
            break;
            
        case 'sa_phone':
        case 'sa_payment_mobile':
            if (value && !validationPatterns.indianMobile.test(value)) {
                showFieldError(field, 'Please enter a valid 10-digit Indian mobile number starting with 6-9');
                return false;
            }
            break;
            
        case 'sa_pincode':
            if (value && !validationPatterns.pinCode.test(value)) {
                showFieldError(field, 'PIN code must be exactly 6 digits');
                return false;
            }
            break;
            
        case 'sa_aadhar_number':
            if (value && !validationPatterns.aadharFormat.test(value)) {
                showFieldError(field, 'Aadhar must be 12 digits in format: 1234 5678 9012');
                return false;
            }
            break;
            
        case 'sa_dob':
            if (value && !validationPatterns.dateFormat.test(value)) {
                showFieldError(field, 'Date must be in DD-MM-YYYY format');
                return false;
            }
            
            // Validate actual date
            if (value && validationPatterns.dateFormat.test(value)) {
                const parts = value.split('-');
                const day = parseInt(parts[0]);
                const month = parseInt(parts[1]);
                const year = parseInt(parts[2]);
                
                const date = new Date(year, month - 1, day);
                
                if (date.getDate() !== day || date.getMonth() !== month - 1 || date.getFullYear() !== year) {
                    showFieldError(field, 'Please enter a valid date');
                    return false;
                }
                
                // Check age between 15 and 25
                const age = calculateAge(date);
                if (age < 15 || age > 25) {
                    showFieldError(field, 'Age must be between 15 and 25 years');
                    return false;
                }
            }
            break;
            
        case 'sa_percentage':
            if (value && (parseFloat(value) < 0 || parseFloat(value) > 100)) {
                showFieldError(field, 'Percentage must be between 0 and 100');
                return false;
            }
            break;
            
        case 'receipt':
            if (field.files.length > 0) {
                const file = field.files[0];
                const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
                if (!allowedTypes.includes(file.type)) {
                    showFieldError(field, 'Only PDF, JPG, and PNG files are allowed');
                    return false;
                }
                if (file.size > 5 * 1024 * 1024) {
                    showFieldError(field, 'File size must be less than 5MB');
                    return false;
                }
            }
            break;
    }
    
    return true;
}

function showFieldError(field, message) {
    field.classList.add('error');
    let errorSpan = field.parentElement.querySelector('.vd-form-error-message');
    if (!errorSpan) {
        errorSpan = document.createElement('span');
        errorSpan.className = 'vd-form-error-message';
        field.parentElement.appendChild(errorSpan);
    }
    errorSpan.textContent = message;
}

function calculateAge(dob) {
    const today = new Date();
    let age = today.getFullYear() - dob.getFullYear();
    const monthDiff = today.getMonth() - dob.getMonth();
    
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
        age--;
    }
    
    return age;
}

// Populate review section
function populateReview() {
    const reviewContent = document.getElementById('reviewContent');
    if (!reviewContent) return;
    
    const formData = new FormData(document.getElementById('admissionForm'));
    
    let html = '<div class="vd-form-summary-table-container">';
    html += '<table class="vd-form-summary-table">';
    
    // Personal Information
    html += '<tr><th colspan="2" style="background: var(--cream); color: var(--primary); text-align: center; padding: 1rem;">Personal Information</th></tr>';
    html += `<tr><th>Full Name:</th><td>${formData.get('sa_name') || 'Not provided'}</td></tr>`;
    html += `<tr><th>Address:</th><td>${formData.get('sa_address') || 'Not provided'}</td></tr>`;
    html += `<tr><th>City:</th><td>${formData.get('sa_city') || 'Not provided'}</td></tr>`;
    html += `<tr><th>State:</th><td>${formData.get('sa_state') || 'Not provided'}</td></tr>`;
    html += `<tr><th>PIN Code:</th><td>${formData.get('sa_pincode') || 'Not provided'}</td></tr>`;
    html += `<tr><th>Phone:</th><td>${formData.get('sa_phone') || 'Not provided'}</td></tr>`;
    html += `<tr><th>Date of Birth:</th><td>${formData.get('sa_dob') || 'Not provided'}</td></tr>`;
    html += `<tr><th>Aadhar Number:</th><td>${formData.get('sa_aadhar_number') || 'Not provided'}</td></tr>`;
    html += `<tr><th>Category:</th><td>${formData.get('sa_category') || 'Not provided'}</td></tr>`;
    html += `<tr><th>Mother's Name:</th><td>${formData.get('sa_mother_name') || 'Not provided'}</td></tr>`;
    html += `<tr><th>Father's Name:</th><td>${formData.get('sa_father_name') || 'Not provided'}</td></tr>`;
    
    // Course Information
    html += '<tr><th colspan="2" style="background: var(--cream); color: var(--primary); text-align: center; padding: 1rem;">Course Information</th></tr>';
    html += `<tr><th>Course:</th><td>${formData.get('sa_course') || 'Not provided'}</td></tr>`;
    
    const subjectCombination = formData.get('sa_subject_combination');
    const subjectText = getSubjectCombinationText(formData.get('sa_course'), subjectCombination);
    html += `<tr><th>Subject Combination:</th><td>${subjectText}</td></tr>`;
    
    html += `<tr><th>First Language:</th><td>${formData.get('sa_first_language') || 'Not provided'}</td></tr>`;
    html += `<tr><th>Second Language:</th><td>${formData.get('sa_second_language') || 'Not provided'}</td></tr>`;
    
    // Academic Details
    html += '<tr><th colspan="2" style="background: var(--cream); color: var(--primary); text-align: center; padding: 1rem;">Academic Details</th></tr>';
    html += `<tr><th>Marks Obtained:</th><td>${formData.get('sa_marks_obtained') || 'Not provided'}</td></tr>`;
    html += `<tr><th>Percentage:</th><td>${formData.get('sa_percentage') ? formData.get('sa_percentage') + '%' : 'Not provided'}</td></tr>`;
    
    // Facilities
    const facilities = [];
    if (formData.get('hostel')) facilities.push('Hostel');
    if (formData.get('bus')) facilities.push('Bus');
    if (formData.get('midday_meals')) facilities.push('Midday Meals');
    if (formData.get('yoga')) facilities.push('Yoga');
    
    html += `<tr><th>Selected Facilities:</th><td>${facilities.length > 0 ? facilities.join(', ') : 'None selected'}</td></tr>`;
    html += `<tr><th>Other Activities:</th><td>${formData.get('sa_other_activities') || 'None specified'}</td></tr>`;
    
    // Payment Information
    html += '<tr><th colspan="2" style="background: var(--cream); color: var(--primary); text-align: center; padding: 1rem;">Payment Information</th></tr>';
    html += `<tr><th>Payment Mobile:</th><td>${formData.get('sa_payment_mobile') || 'Not provided'}</td></tr>`;
    html += `<tr><th>Transaction Number:</th><td>${formData.get('sa_transaction_number') || 'Not provided'}</td></tr>`;
    
    const receiptFile = document.getElementById('receipt').files[0];
    html += `<tr><th>Receipt:</th><td>${receiptFile ? receiptFile.name : 'Not uploaded'}</td></tr>`;
    
    html += '</table>';
    html += '</div>';
    
    reviewContent.innerHTML = html;
}

function getSubjectCombinationText(course, combination) {
    if (!course || !combination) return 'Not provided';
    
    const combos = subjectCombinations[course];
    if (!combos) return combination;
    
    const found = combos.find(c => c.value === combination);
    return found ? found.text : combination;
}

// Show alert message
function showAlert(message, type = 'info') {
    const alertContainer = document.getElementById('alertContainer');
    if (!alertContainer) {
        // Create alert container if it doesn't exist
        const container = document.createElement('div');
        container.id = 'alertContainer';
        container.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 1000; max-width: 400px;';
        document.body.appendChild(container);
    }
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `vd-form-alert vd-form-alert-${type}`;
    alertDiv.style.cssText = 'margin-bottom: 10px; animation: slideIn 0.3s ease-out;';
    alertDiv.innerHTML = `<i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i> ${message}`;
    
    document.getElementById('alertContainer').appendChild(alertDiv);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.parentNode.removeChild(alertDiv);
        }
    }, 5000);
}

// Initialize on DOM content loaded
document.addEventListener('DOMContentLoaded', function() {
    
    // Format Aadhar number
    const aadharInput = document.getElementById('sa_aadhar_number');
    if (aadharInput) {
        aadharInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s/g, '').replace(/\D/g, '');
            let formattedValue = '';
            
            for (let i = 0; i < value.length && i < 12; i++) {
                if (i > 0 && i % 4 === 0) {
                    formattedValue += ' ';
                }
                formattedValue += value[i];
            }
            
            e.target.value = formattedValue;
        });
    }
    
    // Format Date of Birth
    const dobInput = document.getElementById('sa_dob');
    if (dobInput) {
        dobInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            let formattedValue = '';
            
            if (value.length >= 2) {
                formattedValue = value.substring(0, 2) + '-';
                if (value.length >= 4) {
                    formattedValue += value.substring(2, 4) + '-';
                    if (value.length >= 8) {
                        formattedValue += value.substring(4, 8);
                    } else {
                        formattedValue += value.substring(4);
                    }
                } else {
                    formattedValue += value.substring(2);
                }
            } else {
                formattedValue = value;
            }
            
            e.target.value = formattedValue;
        });
    }
    
    // Restrict PIN code to numbers only
    const pincodeInput = document.getElementById('sa_pincode');
    if (pincodeInput) {
        pincodeInput.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '');
        });
    }
    
    // Restrict phone numbers to numbers only
    const phoneInputs = ['sa_phone', 'sa_payment_mobile'];
    phoneInputs.forEach(id => {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/\D/g, '');
            });
        }
    });
    
    // Restrict name fields to alphabets only
    const nameInputs = ['sa_name', 'sa_mother_name', 'sa_father_name'];
    nameInputs.forEach(id => {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/[^a-zA-Z\s]/g, '');
            });
        }
    });
    
    // File upload preview
    const receiptInput = document.getElementById('receipt');
    if (receiptInput) {
        receiptInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const label = document.querySelector('.vd-form-file-upload-label');
            
            if (file && label) {
                label.innerHTML = `<i class="fas fa-file-check"></i><br>${file.name}<br><small>Click to change</small>`;
                label.style.borderColor = '#28a745';
                label.style.background = 'rgba(40, 167, 69, 0.1)';
            }
        });
    }
    
    // Real-time validation on blur
    document.querySelectorAll('input, select, textarea').forEach(field => {
        field.addEventListener('blur', function() {
            if (this.hasAttribute('required') || this.value) {
                validateField(this);
            }
        });
    });
});

// Form submission
document.getElementById('admissionForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (!validateCurrentSection()) {
        return;
    }
    
    // Show loading spinner
    const submitBtn = document.getElementById('submitBtn');
    const loadingSpinner = document.getElementById('loadingSpinner');
    
    if (submitBtn) submitBtn.disabled = true;
    if (loadingSpinner) loadingSpinner.style.display = 'block';
    
    // Submit form
    const formData = new FormData(this);
    
    fetch(this.action, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showAlert(`Application submitted successfully! Your form number is: <strong>${data.form_number}</strong>`, 'success');
            
            // Redirect after 3 seconds
            setTimeout(() => {
                window.location.href = 'success.php?form=' + data.form_number;
            }, 3000);
        } else {
            showAlert(data.message || 'An error occurred. Please try again.', 'error');
            if (submitBtn) submitBtn.disabled = false;
            if (loadingSpinner) loadingSpinner.style.display = 'none';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Network error. Please check your connection and try again.', 'error');
        if (submitBtn) submitBtn.disabled = false;
        if (loadingSpinner) loadingSpinner.style.display = 'none';
    });
});