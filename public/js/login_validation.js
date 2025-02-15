document.addEventListener('DOMContentLoaded', () => {
  // Form elements
  const studentLoginForm = document.getElementById('studentLoginForm');
  const teacherLoginForm = document.getElementById('teacherLoginForm');
  const studentEmailError = document.getElementById('studentEmailError');
  const studentPasswordError = document.getElementById('studentPasswordError');
  const teacherEmailError = document.getElementById('teacherEmailError');
  const teacherPasswordError = document.getElementById('teacherPasswordError');

  // Handle student login
  studentLoginForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      
      // Clear previous errors
      studentEmailError.textContent = '';
      studentPasswordError.textContent = '';
      
      // Remove existing alerts
      const existingStudentAlert = studentLoginForm.querySelector('.alert');
      if (existingStudentAlert) {
          existingStudentAlert.remove();
      }

      const submitButton = studentLoginForm.querySelector('button[type="submit"]');
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
              // Direct redirect to student dashboard
              window.location.replace('/Biometric-Attendance-System/views/student_dashboard.php');
          } else {
              if (data.message.includes("Email not found")) {
                  studentEmailError.textContent = data.message;
              } else if (data.message.includes("Invalid password")) {
                  studentPasswordError.textContent = data.message;
              } else {
                  const alertDiv = document.createElement('div');
                  alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                  alertDiv.innerHTML = `
                      ${data.message}
                      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  `;
                  studentLoginForm.insertBefore(alertDiv, studentLoginForm.firstChild);
              }
          }
      } catch (error) {
          console.error('Login error:', error);
          const alertDiv = document.createElement('div');
          alertDiv.className = 'alert alert-danger alert-dismissible fade show';
          alertDiv.innerHTML = `
              An error occurred during login. Please try again.
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          `;
          studentLoginForm.insertBefore(alertDiv, studentLoginForm.firstChild);
      } finally {
          submitButton.disabled = false;
          submitButton.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i>Login as Student';
      }
  });

  // Handle teacher login
  teacherLoginForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      
      // Clear previous errors
      teacherEmailError.textContent = '';
      teacherPasswordError.textContent = '';
      
      // Remove existing alerts
      const existingTeacherAlert = teacherLoginForm.querySelector('.alert');
      if (existingTeacherAlert) {
          existingTeacherAlert.remove();
      }

      const submitButton = teacherLoginForm.querySelector('button[type="submit"]');
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
              // Direct redirect to teacher dashboard
              window.location.replace = '/Biometric-Attendance-System/views/teacher_dashboard.php';
          } else {
              if (data.message.includes("Email not found")) {
                  teacherEmailError.textContent = data.message;
              } else if (data.message.includes("Invalid password")) {
                  teacherPasswordError.textContent = data.message;
              } else {
                  const alertDiv = document.createElement('div');
                  alertDiv.className = 'alert alert-danger alert-dismissible fade show';
                  alertDiv.innerHTML = `
                      ${data.message}
                      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                  `;
                  teacherLoginForm.insertBefore(alertDiv, teacherLoginForm.firstChild);
              }
          }
      } catch (error) {
          console.error('Login error:', error);
          const alertDiv = document.createElement('div');
          alertDiv.className = 'alert alert-danger alert-dismissible fade show';
          alertDiv.innerHTML = `
              An error occurred during login. Please try again.
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          `;
          teacherLoginForm.insertBefore(alertDiv, teacherLoginForm.firstChild);
      } finally {
          submitButton.disabled = false;
          submitButton.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i>Login as Teacher';
      }
  });
});