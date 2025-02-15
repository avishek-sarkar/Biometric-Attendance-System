document.addEventListener('DOMContentLoaded', () => {
  // Form elements
  const studentLoginForm = document.getElementById('studentLoginForm');
  const teacherLoginForm = document.getElementById('teacherLoginForm');
  const studentEmailError = document.getElementById('studentEmailError');
  const studentPasswordError = document.getElementById('studentPasswordError');
  const teacherEmailError = document.getElementById('teacherEmailError');
  const teacherPasswordError = document.getElementById('teacherPasswordError');

  // Email validation function
  function validateEmail(email) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailRegex.test(email);
  }

  // Student login handler
  studentLoginForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      
      // Clear previous errors
      studentEmailError.textContent = '';
      studentPasswordError.textContent = '';

      // Get form values
      const email = studentLoginForm.querySelector('[name="email"]').value.trim();
      const password = studentLoginForm.querySelector('[name="password"]').value;

      // Validate email
      if (!validateEmail(email)) {
          studentEmailError.textContent = 'Please enter a valid email address';
          return;
      }

      // Validate password
      if (!password) {
          studentPasswordError.textContent = 'Password is required';
          return;
      }
      
      const submitButton = e.target.querySelector('button[type="submit"]');
      submitButton.disabled = true;
      submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Logging in...';
      
      try {
          const formData = new FormData(studentLoginForm);
          const response = await fetch('../controllers/login.php', {
              method: 'POST',
              body: formData
          });
          
          const data = await response.json();
          
          if (data.success) {
              window.location.href = '../views/student_dashboard.php';
              return;
          }
          
          // Handle errors
          if (data.message.includes("Email not found")) {
              studentEmailError.textContent = data.message;
          } else if (data.message.includes("Invalid password")) {
              studentPasswordError.textContent = data.message;
          } else {
              const alertDiv = document.createElement('div');
              alertDiv.className = 'alert alert-danger alert-dismissible fade show';
              alertDiv.innerHTML = `${data.message}
                  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
              studentLoginForm.insertBefore(alertDiv, studentLoginForm.firstChild);
          }
      } catch (error) {
          console.error('Login error:', error);
          const alertDiv = document.createElement('div');
          alertDiv.className = 'alert alert-danger alert-dismissible fade show';
          alertDiv.innerHTML = `An error occurred during login. Please try again.
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
          studentLoginForm.insertBefore(alertDiv, studentLoginForm.firstChild);
      } finally {
          submitButton.disabled = false;
          submitButton.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i>Login as Student';
      }
  });

  // Teacher login handler
  teacherLoginForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      
      // Clear previous errors
      teacherEmailError.textContent = '';
      teacherPasswordError.textContent = '';

      // Get form values
      const email = teacherLoginForm.querySelector('[name="email"]').value.trim();
      const password = teacherLoginForm.querySelector('[name="password"]').value;

      // Validate email
      if (!validateEmail(email)) {
          teacherEmailError.textContent = 'Please enter a valid email address';
          return;
      }

      // Validate password
      if (!password) {
          teacherPasswordError.textContent = 'Password is required';
          return;
      }
      
      const submitButton = e.target.querySelector('button[type="submit"]');
      submitButton.disabled = true;
      submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Logging in...';
      
      try {
          const formData = new FormData(teacherLoginForm);
          const response = await fetch('../controllers/teacher_login.php', {
              method: 'POST',
              body: formData
          });
          
          const data = await response.json();
          
          if (data.success) {
              window.location.href = '../views/teacher_dashboard.php';
              return;
          }
          
          // Handle errors
          if (data.message.includes("Email not found")) {
              teacherEmailError.textContent = data.message;
          } else if (data.message.includes("Invalid password")) {
              teacherPasswordError.textContent = data.message;
          } else {
              const alertDiv = document.createElement('div');
              alertDiv.className = 'alert alert-danger alert-dismissible fade show';
              alertDiv.innerHTML = `${data.message}
                  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
              teacherLoginForm.insertBefore(alertDiv, teacherLoginForm.firstChild);
          }
      } catch (error) {
          console.error('Login error:', error);
          const alertDiv = document.createElement('div');
          alertDiv.className = 'alert alert-danger alert-dismissible fade show';
          alertDiv.innerHTML = `An error occurred during login. Please try again.
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
          teacherLoginForm.insertBefore(alertDiv, teacherLoginForm.firstChild);
      } finally {
          submitButton.disabled = false;
          submitButton.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i>Login as Teacher';
      }
  });
});