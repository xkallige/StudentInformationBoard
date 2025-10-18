<?php
session_start();

// Unset admin session variables
unset($_SESSION['admin_id']);
unset($_SESSION['admin_staff_id']);
unset($_SESSION['admin_logged_in']);

// Destroy session
session_destroy();

// Redirect to login page
header("Location: login.php");
exit();
?>