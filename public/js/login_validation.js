document.addEventListener('DOMContentLoaded', () => {
  const loginForm = document.getElementById('loginForm');
  const emailInput = document.getElementById('email');
  const passwordInput = document.getElementById('password');
  const emailError = document.getElementById('emailError');
  const passwordError = document.getElementById('passwordError');

  // Clear error messages when typing
  emailInput.addEventListener('input', () => {
      emailError.textContent = '';
  });

  passwordInput.addEventListener('input', () => {
      passwordError.textContent = '';
  });

  // Form submission handler
  loginForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      
      // Clear previous errors
      emailError.textContent = '';
      passwordError.textContent = '';
      
      // Remove any existing alerts
      const existingAlert = loginForm.querySelector('.alert');
      if (existingAlert) {
          existingAlert.remove();
      }

      // Show loading state
      const submitButton = loginForm.querySelector('button[type="submit"]');
      submitButton.disabled = true;
      submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Logging in...';
      
      try {
          const formData = new FormData(loginForm);
          
          // Add debug logging
          console.log('Sending request to:', '../controllers/login.php');
          
          const response = await fetch('../controllers/login.php', {
              method: 'POST',
              body: formData
          });

          // Add response debugging
          console.log('Response status:', response.status);
          const contentType = response.headers.get('content-type');
          console.log('Content-Type:', contentType);

          // Check if response is JSON
          if (!contentType || !contentType.includes('application/json')) {
              throw new Error('Server returned non-JSON response');
          }

          const data = await response.json();
          console.log('Response data:', data);

          if (data.success) {
              // Add debug logging for redirect
              console.log('Redirecting to:', data.redirect);
              window.location.href = data.redirect;
          } else {
              // Handle specific error messages
              if (data.message.includes("Email not found")) {
                  emailError.textContent = data.message;
                  emailInput.focus();
              } else if (data.message.includes("Invalid password")) {
                  passwordError.textContent = data.message;
                  passwordInput.focus();
              } else {
                  // Show general error message
                  const alertDiv = document.createElement('div');
                  alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                  alertDiv.innerHTML = `
                      ${data.message}
                      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  `;
                  loginForm.insertBefore(alertDiv, loginForm.firstChild);
              }
          }
      } catch (error) {
          console.error('Login error:', error);
          // Show user-friendly error message
          const alertDiv = document.createElement('div');
          alertDiv.className = 'alert alert-danger alert-dismissible fade show';
          alertDiv.innerHTML = `
              An error occurred during login. Please try again.
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          `;
          loginForm.insertBefore(alertDiv, loginForm.firstChild);
      } finally {
          // Restore button state
          submitButton.disabled = false;
          submitButton.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i>Login';
      }
  });
});