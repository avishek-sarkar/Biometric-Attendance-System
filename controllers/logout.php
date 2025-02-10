<!-- <?php

// session_start();

// unset($_SESSION['authenticated']);
// unset($_SESSION['auth_user']);
// $_SESSION['status'] = "You are logged out.";
// header('location: ../views/login_form.php');

?> -->

<?php
session_start();
// Clear all session data
$_SESSION = array();
// Destroy session cookie
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-3600, '/');
}
// Destroy session
session_destroy();
$_SESSION['status'] = "You are logged out successfully.";
header('Location: ../views/login_form.php');
exit();
?>