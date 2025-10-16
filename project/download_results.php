<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  header("Location: login.php");
  exit();
}

$lhost = 'localhost';
$dbuser = 'root';
$pass = '';
$db = 'citwebsite';

$connection = mysqli_connect($lhost, $dbuser, $pass, $db);

if (!$connection) {
  die("Database connection failed: " . mysqli_connect_error());
}

$regno = $_SESSION['regno'];

// Fetch student result
$query = "SELECT result_file_path FROM student_results WHERE regno='$regno' LIMIT 1";
$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $file_path = $row['result_file_path'];

  // Check if file exists
  if (file_exists($file_path)) {
    // Set headers to force download
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
    header('Content-Length: ' . filesize($file_path));
    
    // Read and output file
    readfile($file_path);
    exit();
  } else {
    $_SESSION['message'] = "❌ Result file not found on server!";
    header("Location: dashboard.php");
    exit();
  }
} else {
  $_SESSION['message'] = "❌ No result available for download!";
  header("Location: dashboard.php");
  exit();
}
?>