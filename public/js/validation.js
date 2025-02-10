// Form validation functions
function validateName(name) {
    if (name.length < 2) {
        return "Name must be at least 2 characters long";
    }
    return "";
}

function validateRoll(roll) {
    const rollRegex = /^\d{8}$/;
    if (!rollRegex.test(roll)) {
        return "Roll number must be exactly 8 digits";
    }
    return "";
}

function validateReg(reg) {
    const regRegex = /^\d{4,}$/;
    if (!regRegex.test(reg)) {
        return "Registration number must be at least 4 digits";
    }
    return "";
}

function validateSession(session) {
    // Updated regex to handle the exact format YYYY-YY
    const sessionRegex = /^20\d{2}-\d{2}$/;
    if (!sessionRegex.test(session)) {
        return "Session must be in format YYYY-YY (e.g., 2020-21)";
    }
    
    // Extract years and validate the range
    const startYear = parseInt(session.substring(0, 4));
    const endYear = parseInt(session.substring(5));
    
    // Convert end year to full year for comparison (e.g., 21 -> 2021)
    const endYearFull = parseInt(`20${endYear}`);
    
    // Check if end year is start year + 1
    if (endYearFull !== startYear + 1) {
        return "Invalid session year range";
    }
    return "";
}

function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        return "Please enter a valid email address";
    }
    return "";
}

function validatePhone(phone) {
    // Updated regex to specifically handle +880 format
    const cleanPhone = phone.replace(/\s+/g, '');
    if (!cleanPhone.startsWith('+880')) {
        return "Phone number must start with +880";
    }
    const phoneRegex = /^\+880[0-9]{10}$/;
    if (!phoneRegex.test(cleanPhone)) {
        return "Please enter a valid Bangladeshi phone number (+880XXXXXXXXXX)";
    }
    return "";
}

function validatePassword(password) {
    if (password.length < 8) {
        return "Password must be at least 8 characters long";
    }
    if (!/[A-Z]/.test(password)) {
        return "Password must contain at least one uppercase letter";
    }
    if (!/[a-z]/.test(password)) {
        return "Password must contain at least one lowercase letter";
    }
    if (!/\d/.test(password)) {
        return "Password must contain at least one number";
    }
    if (!/[!@#$%^&*]/.test(password)) {
        return "Password must contain at least one special character (!@#$%^&*)";
    }
    return "";
}

function validateConfirmPassword(password, confirmPassword) {
    if (password !== confirmPassword) {
        return "Passwords do not match";
    }
    return "";
}

// Function to check duplicates
async function checkDuplicate(field, value) {
    try {
        const formData = new FormData();
        formData.append('field', field);
        formData.append('value', value);
        //check_duplicate.php file is checking the duplicates from the database
        const response = await fetch('/Biometric-Attendance-System/controllers/check_duplicate.php', {
            method: 'POST',
            body: formData
        });
        
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        
        const data = await response.json();
        return data.exists ? data.message : "";
    } catch (error) {
        console.error('Error checking duplicate:', error);
        return "";
    }
}

// Password toggle function
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const toggleIcon = document.getElementById(`toggle${fieldId.charAt(0).toUpperCase() + fieldId.slice(1)}`);
    
    if (field.type === "password") {
        field.type = "text";
        toggleIcon.classList.remove("bi-eye-slash");
        toggleIcon.classList.add("bi-eye");
    } else {
        field.type = "password";
        toggleIcon.classList.remove("bi-eye");
        toggleIcon.classList.add("bi-eye-slash");
    }
}

// Main validation setup
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registrationForm');
    const fields = ['name', 'roll', 'reg', 'session', 'email', 'phone', 'password', 'confirmPassword'];
    let debounceTimers = {};

    // Initialize phone input with +880
    const phoneInput = document.getElementById('phone');
    if (!phoneInput.value) {
        phoneInput.value = '+880';
    }

    // Handle phone input formatting
    phoneInput.addEventListener('input', function(e) {
        let value = e.target.value;
        
        // Ensure value starts with +880
        if (!value.startsWith('+880')) {
            value = '+880';
        }
        
        // Only allow numbers after +880
        if (value.length > 4) {
            const numbers = value.slice(4).replace(/[^\d]/g, '');
            value = '+880' + numbers;
        }
        
        // Limit to maximum length (+880 + 10 digits)
        if (value.length > 14) {
            value = value.slice(0, 14);
        }
        
        this.value = value;
    });

    // Prevent deletion of +880 prefix
    phoneInput.addEventListener('keydown', function(e) {
        if (e.key === 'Backspace' && this.value.length <= 4) {
            e.preventDefault();
        }
    });

    // Fields that need duplicate checking
    const duplicateCheckFields = ['roll', 'reg', 'email', 'phone'];

    // Validation function for each field
    const validateField = async (field, value) => {
        let error = "";
        
        // First do client-side validation
        switch(field) {
            case 'name':
                error = validateName(value);
                break;
            case 'roll':
                error = validateRoll(value);
                break;
            case 'reg':
                error = validateReg(value);
                break;
            case 'session':
                error = validateSession(value);
                break;
            case 'email':
                error = validateEmail(value);
                break;
            case 'phone':
                error = validatePhone(value);
                break;
            case 'password':
                error = validatePassword(value);
                break;
            case 'confirmPassword':
                error = validateConfirmPassword(
                    document.getElementById('password').value,
                    value
                );
                break;
        }

        // If no client-side error and field needs duplicate check
        if (!error && duplicateCheckFields.includes(field)) {
            error = await checkDuplicate(field, value);
        }

        return error;
    };

    // Add input event listeners for real-time validation
    fields.forEach(field => {
        const input = document.getElementById(field);
        const errorDiv = document.getElementById(`${field}Error`);

        input.addEventListener('input', function() {
            // Clear existing timer
            if (debounceTimers[field]) {
                clearTimeout(debounceTimers[field]);
            }

            // Set new timer
            debounceTimers[field] = setTimeout(async () => {
                const error = await validateField(field, this.value);
                errorDiv.textContent = error;
                this.classList.toggle('is-invalid', error !== '');
                this.classList.toggle('is-valid', error === '' && this.value !== '');

                // For password field, also validate confirm password
                if (field === 'password') {
                    const confirmPassword = document.getElementById('confirmPassword');
                    if (confirmPassword.value) {
                        const confirmError = validateConfirmPassword(this.value, confirmPassword.value);
                        document.getElementById('confirmPasswordError').textContent = confirmError;
                        confirmPassword.classList.toggle('is-invalid', confirmError !== '');
                        confirmPassword.classList.toggle('is-valid', confirmError === '' && confirmPassword.value !== '');
                    }
                }
            }, 500); // 500ms delay
        });
    });

    // Form submission handling
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        // Show loading spinner
        const loadingElement = document.getElementById('loading');
        loadingElement.style.display = 'block';

        let hasErrors = false;

        // Validate all fields
        for (const field of fields) {
            const input = document.getElementById(field);
            const errorDiv = document.getElementById(`${field}Error`);
            
            const error = await validateField(field, input.value);
            
            errorDiv.textContent = error;
            if (error) {
                hasErrors = true;
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
            }
        }

        // Hide loading spinner if there are errors
        if (hasErrors) {
            loadingElement.style.display = 'none';
            return;
        }

        // If no errors, proceed with form submission
        const formData = new FormData(this);
        
        try {
            //response for mail send
            const response = await fetch('/Biometric-Attendance-System/controllers/send_mail.php', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success && data.redirect) {
                // Redirect to verification page
                window.location.href = data.redirect;
            } else {
                // Handle error case
                loadingElement.style.display = 'none';
                alert('Registration failed: ' + (data.message || 'Unknown error'));
            }
        } catch (error) {
            console.error('Error:', error);
            loadingElement.style.display = 'none';
            alert('An error occurred during registration. Please try again.');
        }
    });
});