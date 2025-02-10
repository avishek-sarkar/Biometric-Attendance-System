document.addEventListener('DOMContentLoaded', () => {
  // Load Navbar
  fetch('/Biometric-Attendance-System/includes/navbar.php')
      .then(response => response.text())
      .then(data => {
          document.getElementById('navbar-placeholder').innerHTML = data;
          initializeNavBar();
      })
      .catch(error => console.error('Error loading navbar:', error));

  // Load Footer
  fetch('/Biometric-Attendance-System/includes/footer.php')
      .then(response => response.text())
      .then(data => {
          document.getElementById('footer-placeholder').innerHTML = data;
      })
      .catch(error => console.error('Error loading footer:', error));
});

function initializeNavBar() {
  const navIcon = document.getElementById('navIcon');
  const sidePanel = document.getElementById('sidePanel');

  if (navIcon && sidePanel) {
      navIcon.addEventListener('click', (e) => {
          e.stopPropagation();
          sidePanel.style.width = sidePanel.style.width === '250px' ? '0' : '250px';
      });

      document.addEventListener('click', (e) => {
          if (!sidePanel.contains(e.target) && !navIcon.contains(e.target)) {
              sidePanel.style.width = '0';
          }
      });
  }
}