<?php
session_start();

if (!isset($_SESSION['authenticated'])) {
  $_SESSION['status'] = "You are not logged in. Please log in first.";
  header('Location: /Biometric-Attendance-System/views/login_form.php');
  exit();
}

?>