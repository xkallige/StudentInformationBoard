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

// Get all students
$students_query = "SELECT g.*, 
                   (SELECT COUNT(*) FROM student_results WHERE regno = g.regno) as has_result
                   FROM groupseven g 
                   ORDER BY g.username ASC";
$students = mysqli_query($connection, $students_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>View Students</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="dashboard.css" />
  <link rel="stylesheet" href="popup.css" />
  <style>
    .students-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
      overflow-x: auto;
      display: block;
    }
    .students-table table {
      width: 100%;
      min-width: 600px;
    }
    .students-table th, .students-table td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    .students-table th {
      background: #8B0000;
      color: white;
      font-weight: 600;
    }
    .students-table tr:hover {
      background: #f5f5f5;
    }
    .status-badge {
      padding: 4px 10px;
      border-radius: 12px;
      font-size: 0.85em;
      font-weight: 600;
    }
    .status-yes {
      background: #d4edda;
      color: #155724;
    }
    .status-no {
      background: #f8d7da;
      color: #721c24;
    }
    .search-box {
      width: 100%;
      padding: 12px;
      margin-bottom: 20px;
      border: 1px solid #ddd;
      border-radius: 6px;
      font-size: 15px;
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
        <h1 class="logo">View Students</h1>
      </div>
      <button class="navbar-toggle" aria-label="Open navigation menu" onclick="document.querySelector('.navbar ul').classList.toggle('show-nav')">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <ul>
        <li><a href="admin_dashboard.php">Dashboard</a></li>
        <li><a href="view_students.php" class="active">View Students</a></li>
        <li><a href="upload_result.php">Upload Result</a></li>
        <li><a href="manage_results.php">Manage Results</a></li>
        <li><a href="admin_logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>

  <section class="hero">
    <h2>👥 All Registered Students</h2>
    <p>View all students and their result status</p>
  </section>

  <section class="dashboard-container" style="padding:40px 20px;max-width:1200px;margin:auto;">
    <div class="card">
      <h3 style="color:#8B0000;">Student List</h3>
      
      <input type="text" id="searchInput" class="search-box" placeholder="🔍 Search by name, regno, or email..." onkeyup="searchTable()">
      
      <?php if (mysqli_num_rows($students) > 0): ?>
        <div class="students-table">
          <table id="studentsTable">
            <thead>
              <tr>
                <th>Full Name</th>
                <th>Registration Number</th>
                <th>Email</th>
                <th>Result Uploaded</th>
                <th>Registered Date</th>
              </tr>
            </thead>
            <tbody>
              <?php while($row = mysqli_fetch_assoc($students)): ?>
                <tr>
                  <td><?php echo htmlspecialchars($row['username']); ?></td>
                  <td><?php echo htmlspecialchars($row['regno']); ?></td>
                  <td><?php echo htmlspecialchars($row['email']); ?></td>
                  <td>
                    <?php if($row['has_result'] > 0): ?>
                      <span class="status-badge status-yes">✓ Yes</span>
                    <?php else: ?>
                      <span class="status-badge status-no">✗ No</span>
                    <?php endif; ?>
                  </td>
                  <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <p style="text-align:center;color:#888;margin:30px 0;">No students registered yet.</p>
      <?php endif; ?>
    </div>

    <div style="text-align:center;margin:30px 0;">
      <a href="admin_dashboard.php" class="btn-view" style="text-decoration:none;display:inline-block;">⬅️ Back to Dashboard</a>
    </div>
  </section>

  <footer>
    <p>&copy; 2025 Department of Computer Science</p>
  </footer>

  <script>
    function searchTable() {
      const input = document.getElementById("searchInput");
      const filter = input.value.toUpperCase();
      const table = document.getElementById("studentsTable");
      const tr = table.getElementsByTagName("tr");

      for (let i = 1; i < tr.length; i++) {
        const tdName = tr[i].getElementsByTagName("td")[0];
        const tdRegno = tr[i].getElementsByTagName("td")[1];
        const tdEmail = tr[i].getElementsByTagName("td")[2];
        
        if (tdName || tdRegno || tdEmail) {
          const nameValue = tdName.textContent || tdName.innerText;
          const regnoValue = tdRegno.textContent || tdRegno.innerText;
          const emailValue = tdEmail.textContent || tdEmail.innerText;
          
          if (nameValue.toUpperCase().indexOf(filter) > -1 || 
              regnoValue.toUpperCase().indexOf(filter) > -1 ||
              emailValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
  </script>
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