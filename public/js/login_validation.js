document.addEventListener('DOMContentLoaded', () => {
  const loginForm = document.getElementById('loginForm');
  const emailInput = document.getElementById('email');
  const passwordInput = document.getElementById('password');
  const emailError = document.getElementById('emailError');
  const passwordError = document.getElementById('passwordError');

  // Clear error messages when user starts typing
  emailInput.addEventListener('input', () => {
      emailError.textContent = '';
  });

  passwordInput.addEventListener('input', () => {
      passwordError.textContent = '';
  });

  // Form submission handler
  loginForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      
      // Clear previous error messages
      emailError.textContent = '';
      passwordError.textContent = '';
      
      const formData = new FormData(loginForm);
      
      try {
          const response = await fetch('../models/login.php', {
              method: 'POST',
              body: formData
          });
          
          const data = await response.json();
          
          if (data.success) {
              window.location.href = data.redirect;
          } else {
              // Show error message based on type
              if (data.message.includes("Email not found")) {
                  emailError.textContent = data.message;
                  passwordError.textContent = '';
              } else if (data.message.includes("Invalid password")) {
                  passwordError.textContent = data.message;
                  emailError.textContent = '';
              } else {
                  // Show general error
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
          alert('An error occurred during login. Please try again.');
      }
  });
});