// Form validation functions
function validateName(name) {
  if (name.length < 2) {
      return "Name must be at least 2 characters long";
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
  // Clean the phone number first
  const cleanPhone = phone.replace(/\s+/g, '');
  
  // Check if starts with +880
  if (!cleanPhone.startsWith('+880')) {
      return "Phone number must start with +880";
  }
  
  // Check for exactly 14 characters (+880 + 10 digits)
  if (cleanPhone.length !== 14) {
      return "Phone number must be exactly 10 digits after +880";
  }
  
  // Validate the format: +880 followed by 10 digits
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

// Function to check duplicates
async function checkDuplicate(field, value) {
  try {
      const response = await fetch('../controllers/check_teacher_duplicate.php', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: `field=${field}&value=${value}`
      });
      return await response.json();
  } catch (error) {
      console.error('Error:', error);
      return { exists: false };
  }
}

// Password toggle function
function togglePassword(fieldId) {
  const field = document.getElementById(fieldId);
  const icon = field.nextElementSibling.querySelector('i');
  
  if (field.type === 'password') {
      field.type = 'text';
      icon.classList.replace('bi-eye-slash', 'bi-eye');
  } else {
      field.type = 'password';
      icon.classList.replace('bi-eye', 'bi-eye-slash');
  }
}

// Main validation setup
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('teacherRegistrationForm');
  const fields = ['name', 'designation', 'department', 'email', 'phone', 'password', 'confirmPassword'];
  let debounceTimers = {};

  // Initialize phone input with +880
  const phoneInput = document.getElementById('phone');
  if (!phoneInput.value) {
      phoneInput.value = '+880';
  }

  // Handle phone input formatting
  phoneInput.addEventListener('input', function(e) {
      let value = e.target.value;
      
      if (!value.startsWith('+880')) {
          value = '+880';
      }
      
      if (value.length > 4) {
          const numbers = value.slice(4).replace(/[^\d]/g, '');
          value = '+880' + numbers.slice(0, 10);
      }
      
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
  const duplicateCheckFields = ['email', 'phone'];

  async function validateField(field, value) {
      let error = "";
      
      switch(field) {
          case 'name':
              error = validateName(value);
              break;
          case 'email':
              error = validateEmail(value);
              if (!error && duplicateCheckFields.includes(field)) {
                  const response = await checkDuplicate(field, value);
                  if (response.exists) {
                      error = response.message;
                  }
              }
              break;
          case 'phone':
              error = validatePhone(value);
              if (!error && duplicateCheckFields.includes(field)) {
                  const response = await checkDuplicate(field, value);
                  if (response.exists) {
                      error = response.message;
                  }
              }
              break;
          case 'password':
              error = validatePassword(value);
              break;
          case 'confirmPassword':
              const password = document.getElementById('password').value;
              if (password !== value) {
                  error = "Passwords do not match";
              }
              break;
          case 'designation':
          case 'department':
              if (!value) {
                  error = `Please select a ${field}`;
              }
              break;
      }
      return error;
  }

  // Form submission handler
  form.addEventListener('submit', async function(e) {
      e.preventDefault();
      
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

      if (hasErrors) {
          loadingElement.style.display = 'none';
          return;
      }

      // If no errors, proceed with form submission
      const formData = new FormData(this);
      
      try {
          const response = await fetch('../controllers/teacher_registration.php', {
              method: 'POST',
              body: formData
          });
          
          const data = await response.json();
          
          if (data.success) {
              window.location.href = data.redirect;
          } else {
              loadingElement.style.display = 'none';
              alert('Registration failed: ' + (data.message || 'Unknown error'));
          }
      } catch (error) {
          console.error('Error:', error);
          loadingElement.style.display = 'none';
          alert('An error occurred during registration. Please try again.');
      }
  });

  // Real-time validation
  fields.forEach(field => {
      const input = document.getElementById(field);
      const errorDiv = document.getElementById(`${field}Error`);

      input.addEventListener('input', function() {
          if (debounceTimers[field]) {
              clearTimeout(debounceTimers[field]);
          }

          debounceTimers[field] = setTimeout(async () => {
              const error = await validateField(field, this.value);
              errorDiv.textContent = error;
              input.classList.toggle('is-invalid', error !== '');
              input.classList.toggle('is-valid', error === '' && this.value !== '');
          }, 500);
      });
  });
});