<?php
session_start();

// Redirect to login if not logged in as admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  header("Location: login.php");
  exit();
}

$lhost = 'sql300.infinityfree.com';
$dbuser = 'if0_40184676';
$pass = 'ejikegoodness01';
$db = 'if0_40184676_citwebsite';

$connection = mysqli_connect($lhost, $dbuser, $pass, $db);

if (!$connection) {
  die("Database connection failed: " . mysqli_connect_error());
}

// Handle Delete
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  
  // Get file path before deleting
  $get_file = "SELECT result_file_path FROM student_results WHERE id='$id' LIMIT 1";
  $file_result = mysqli_query($connection, $get_file);
  
  if (mysqli_num_rows($file_result) > 0) {
    $file_path = mysqli_fetch_assoc($file_result)['result_file_path'];
    
    // Delete file
    if (file_exists($file_path)) {
      unlink($file_path);
    }
    
    // Delete from database
    $delete_query = "DELETE FROM student_results WHERE id='$id'";
    $delete = mysqli_query($connection, $delete_query);
    
    if ($delete) {
      $_SESSION['message'] = "✅ Result deleted successfully!";
    } else {
      $_SESSION['message'] = "❌ Failed to delete result!";
    }
  }
  
  header("Location: manage_results.php");
  exit();
}

// Get all results
$results_query = "SELECT sr.*, g.username FROM student_results sr 
                  JOIN groupseven g ON sr.regno = g.regno 
                  ORDER BY sr.uploaded_at DESC";
$results = mysqli_query($connection, $results_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Manage Results</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="dashboard.css" />
  <link rel="stylesheet" href="popup.css" />
  <style>
    .results-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      overflow-x: auto;
      display: block;
    }
    .results-table table {
      width: 100%;
      min-width: 600px;
    }
    .results-table th, .results-table td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    .results-table th {
      background: #8B0000;
      color: white;
      font-weight: 600;
    }
    .results-table tr:hover {
      background: #f5f5f5;
    }
    .action-btn {
      padding: 6px 12px;
      margin: 0 5px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      text-decoration: none;
      display: inline-block;
      font-size: 0.9em;
    }
    .btn-delete {
      background: #dc3545;
      color: white;
    }
    .btn-delete:hover {
      background: #c82333;
    }
    .btn-view-file {
      background: #228B22;
      color: white;
    }
    .btn-view-file:hover {
      background: #006400;
    }
  </style>
</head>
<body>
  <header>
    <nav class="navbar">
      <div class="navbar-first">
        <div class="navbar-logos">
          <img src="futo_logo.png" alt="FUTO Logo" class="logo-img" />
          <img src="nacos.png" alt="NACOSS Logo" class="logo-img" />
        </div>
        <h1 class="logo">Manage Results</h1>
      </div>
      <button class="navbar-toggle" aria-label="Open navigation menu" onclick="document.querySelector('.navbar ul').classList.toggle('show-nav')">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <ul>
        <li><a href="admin_dashboard.php">Dashboard</a></li>
        <li><a href="view_students.php">View Students</a></li>
        <li><a href="upload_result.php">Upload Result</a></li>
        <li><a href="manage_results.php" class="active">Manage Results</a></li>
        <li><a href="admin_logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <section class="hero">
    <h2>📋 Manage Results</h2>
    <p>View and manage all uploaded results</p>
  </section>

  <section class="dashboard-container" style="padding:40px 20px;max-width:1200px;margin:auto;">
    <div class="card">
      <h3 style="color:#8B0000;">All Uploaded Results</h3>
      
      <?php if (mysqli_num_rows($results) > 0): ?>
        <div class="results-table">
          <table>
            <thead>
              <tr>
                <th>Student Name</th>
                <th>Reg No</th>
                <th>Semester</th>
                <th>Session</th>
                <th>Upload Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php while($row = mysqli_fetch_assoc($results)): ?>
                <tr>
                  <td><?php echo htmlspecialchars($row['username']); ?></td>
                  <td><?php echo htmlspecialchars($row['regno']); ?></td>
                  <td><?php echo htmlspecialchars($row['semester']); ?></td>
                  <td><?php echo htmlspecialchars($row['session']); ?></td>
                  <td><?php echo date('M d, Y', strtotime($row['uploaded_at'])); ?></td>
                  <td>
                    <a href="<?php echo $row['result_file_path']; ?>" target="_blank" class="action-btn btn-view-file">View PDF</a>
                    <a href="manage_results.php?delete=<?php echo $row['id']; ?>" 
                       class="action-btn btn-delete" 
                       onclick="return confirm('Are you sure you want to delete this result?');">Delete</a>
                  </td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <p style="text-align:center;color:#888;margin:30px 0;">No results uploaded yet.</p>
      <?php endif; ?>
    </div>

    <div style="text-align:center;margin:30px 0;">
      <a href="admin_dashboard.php" class="btn-view" style="text-decoration:none;display:inline-block;">⬅️ Back to Dashboard</a>
    </div>
  </section>

  <footer>
    <p>&copy; 2025 Department of Computer Science</p>
  </footer>

  <script src="popup.js"></script>
</body>
</html>

<?php if (!empty($_SESSION['message'])): ?>
  <div id="popup" class="popup" style="display:flex;">
    <div class="popup-content">
      <span id="close-popup" class="close">&times;</span>
      <p><?php echo $_SESSION['message']; ?></p>
    </div>
  </div>
  <?php unset($_SESSION['message']); ?>
<?php endif; ?>