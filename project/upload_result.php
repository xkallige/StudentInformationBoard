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

// Handle file upload
if (isset($_POST['upload_result'])) {
  $regno = trim($_POST['regno']);
  $semester = trim($_POST['semester']);
  $session = trim($_POST['session']);

  // Check if student exists
  $check_student = "SELECT * FROM groupseven WHERE regno='$regno' LIMIT 1";
  $student_result = mysqli_query($connection, $check_student);

  if (mysqli_num_rows($student_result) == 0) {
    $_SESSION['message'] = "❌ Student with regno $regno does not exist!";
    header("Location: upload_result.php");
    exit();
  }

  // Check if file was uploaded
  if (isset($_FILES['result_file']) && $_FILES['result_file']['error'] == 0) {
    $file_name = $_FILES['result_file']['name'];
    $file_tmp = $_FILES['result_file']['tmp_name'];
    $file_size = $_FILES['result_file']['size'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Validate file type
    if ($file_ext !== 'pdf') {
      $_SESSION['message'] = "❌ Only PDF files are allowed!";
      header("Location: upload_result.php");
      exit();
    }

    // Validate file size (max 5MB)
    if ($file_size > 5242880) {
      $_SESSION['message'] = "❌ File size must be less than 5MB!";
      header("Location: upload_result.php");
      exit();
    }

    // Create results folder if it doesn't exist
    if (!file_exists('results')) {
      mkdir('results', 0777, true);
    }

    // Generate unique filename
    $new_filename = $regno . '_' . time() . '.pdf';
    $upload_path = 'results/' . $new_filename;

    // Move uploaded file
    if (move_uploaded_file($file_tmp, $upload_path)) {
      // Check if result already exists for this student
      $check_query = "SELECT * FROM student_results WHERE regno='$regno' LIMIT 1";
      $check_result = mysqli_query($connection, $check_query);

      if (mysqli_num_rows($check_result) > 0) {
        // Update existing result
        $old_file = mysqli_fetch_assoc($check_result)['result_file_path'];
        
        // Delete old file
        if (file_exists($old_file)) {
          unlink($old_file);
        }

        $query = "UPDATE student_results SET semester='$semester', session='$session', 
                  result_file_path='$upload_path', uploaded_at=NOW() WHERE regno='$regno'";
      } else {
        // Insert new result
        $query = "INSERT INTO student_results (regno, semester, session, result_file_path) 
                  VALUES ('$regno', '$semester', '$session', '$upload_path')";
      }

      $upload = mysqli_query($connection, $query);

      if ($upload) {
        $_SESSION['message'] = "✅ Result uploaded successfully for regno: $regno";
      } else {
        $_SESSION['message'] = "❌ Database error: " . mysqli_error($connection);
      }
    } else {
      $_SESSION['message'] = "❌ Failed to upload file!";
    }
  } else {
    $_SESSION['message'] = "❌ Please select a PDF file to upload!";
  }

  header("Location: upload_result.php");
  exit();
}

// Get all students
$students_query = "SELECT regno, username FROM groupseven ORDER BY username ASC";
$students_result = mysqli_query($connection, $students_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Upload Result</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="dashboard.css" />
  <link rel="stylesheet" href="popup.css" />
</head>
<body>
  <header>
    <nav class="navbar">
      <div class="navbar-first">
        <div class="navbar-logos">
          <img src="futo_logo.png" alt="FUTO Logo" class="logo-img" />
          <img src="nacos.png" alt="NACOSS Logo" class="logo-img" />
        </div>
        <h1 class="logo">Upload Result</h1>
      </div>
      <button class="navbar-toggle" aria-label="Open navigation menu" onclick="document.querySelector('.navbar ul').classList.toggle('show-nav')">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <ul>
        <li><a href="admin_dashboard.php">Dashboard</a></li>
        <li><a href="view_students.php">View Students</a></li>
        <li><a href="upload_result.php" class="active">Upload Result</a></li>
        <li><a href="manage_results.php">Manage Results</a></li>
        <li><a href="admin_logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <section class="hero">
    <h2>📤 Upload Student Result</h2>
    <p>Upload PDF result for a student</p>
  </section>

  <section class="dashboard-container" style="padding:40px 20px;max-width:800px;margin:auto;">
    <div class="card">
      <h3 style="color:#8B0000;">Upload Result Form</h3>
      <form method="POST" action="upload_result.php" enctype="multipart/form-data" class="profile-form">
        
        <label>Select Student:</label>
        <select name="regno" required style="width:100%;padding:12px;border:1px solid #ddd;border-radius:6px;font-size:15px;">
          <option value="">-- Select Student --</option>
          <?php while($student = mysqli_fetch_assoc($students_result)): ?>
            <option value="<?php echo $student['regno']; ?>">
              <?php echo htmlspecialchars($student['username']) . ' (' . $student['regno'] . ')'; ?>
            </option>
          <?php endwhile; ?>
        </select>

        <label>Semester:</label>
        <input type="text" name="semester" placeholder="e.g., First Semester" required />

        <label>Session:</label>
        <input type="text" name="session" placeholder="e.g., 2024/2025" required />

        <label>Select PDF File:</label>
        <input type="file" name="result_file" accept=".pdf" required 
               style="padding:10px;border:1px solid #ddd;border-radius:6px;"/>

        <p style="font-size:0.9em;color:#666;margin-top:5px;">
          * Maximum file size: 5MB<br/>
          * Only PDF files are allowed
        </p>

        <button type="submit" name="upload_result" class="btn-save" style="background:#8B0000;">Upload Result</button>
      </form>
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