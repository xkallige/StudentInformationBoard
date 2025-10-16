<?php
session_start();

$lhost = 'localhost';
$dbuser = 'root';
$pass = '';
$db = 'citwebsite';

$connection = mysqli_connect($lhost, $dbuser, $pass, $db);

if (!$connection) {
  die("Database connection failed: " . mysqli_connect_error());
}

if (isset($_POST['register'])) {
  $username = trim($_POST['username']);
  $regno = trim($_POST['regno']);
  $email = trim($_POST['email']);
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm-password'];

  // 1️⃣ Validate regno length (must be exactly 11 characters)
  if (!preg_match('/^\d{11}$/', $regno)) {
    $_SESSION['message'] = "❌ Registration number must be exactly 11 digits!";
    $_SESSION['show_register'] = true;
    header("Location: login.php");
    exit();
  }

  // 2️⃣ Validate email format
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['message'] = "❌ Please enter a valid email address!";
    $_SESSION['show_register'] = true;
    header("Location: login.php");
    exit();
  }

  // 3️⃣ Validate password strength (at least one letter and one number, 6+ chars)
  if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*]{8,}$/', $password)) {
    $_SESSION['message'] = "❌ Password must contain more than 8 values, a character and a number!";
    $_SESSION['show_register'] = true;
    header("Location: login.php");
    exit();
  }

  // check if passwords match
  if ($password !== $confirmPassword) {
    $_SESSION['message'] = "❌ Passwords do not match!";
    $_SESSION['show_register'] = true;
    header("Location: login.php");
    exit();
  }

  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  $query = "INSERT INTO groupseven (username, regno, email, password)
            VALUES ('$username', '$regno', '$email', '$hashedPassword')";

  $insert = mysqli_query($connection, $query);

  if ($insert) {
    $_SESSION['message'] = "✅ Registration successful!";
  } else {
    $_SESSION['message'] = "❌ Registration failed: " . mysqli_error($connection);
    $_SESSION['show_register'] = true;
  }

  header("Location: login.php");
  exit();
}

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $query = "SELECT * FROM groupseven WHERE username = '$username' LIMIT 1";
  $result = mysqli_query($connection, $query);

  if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);

    if (password_verify($password, $user['password'])) {
      // ✅ Store user details in session
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['regno'] = $user['regno'];
      $_SESSION['email'] = $user['email'];
      $_SESSION['logged_in'] = true;

      $_SESSION['message'] = "✅ Login successful! Welcome, " . $user['username'];
      $_SESSION['redirect_to_home'] = true;
      header("Location: login.php");
      exit();
    } else {
      $_SESSION['message'] = "❌ Incorrect password!";
      header("Location: login.php");
      exit();
    }
  } else {
    $_SESSION['message'] = "❌ Username not found!";
    header("Location: login.php");
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Student Info Board</title>
  <link rel="stylesheet" href="login.css">
  <link rel="stylesheet" href="popup.css">
</head>
<body>
  <header>
    <nav class="navbar">
      <div class="navbar-first">
          <div class="navbar-logos">
            <img src="futo_logo.png" alt="FUTO Logo" class="logo-img"/>
            <img src="nacos.png" alt="NACOSS Logo" class="logo-img"/>
        </div>
      <h1 class="logo">Student Information Board</h1>
      </div>
      <button class="navbar-toggle" aria-label="Open navigation menu" onclick="document.querySelector('.navbar ul').classList.toggle('show-nav')">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <ul>
        <!-- <li><a href="home.php">Home</a></li>
        <li><a href="announcements.html">Announcements</a></li>
        <li><a href="events.html">Events</a></li>
        <li><a href="timetable.html">Timetable</a></li> 
        <li><a href="login.php" class="active">Login</a></li> -->
      </ul>
    </nav>
  </header>
  <section class="auth-section">
    <div class="auth-card">
      <div class="auth-icon">🎓</div>
      <h2 class="auth-title">Student Information Board</h2>
      <p class="auth-subtitle">Access departmental announcements and events</p>

      <div class="auth-tabs">
        <button id="signInTab" class="tab-btn active">Sign In</button>
        <button id="signUpTab" class="tab-btn">Sign Up</button>
      </div>

      <!-- Sign In Form -->
      <form id="signInForm" class="login-form" method="POST" action="login.php">
        <label>Full Name</label>
        <input type="text" name="username" placeholder="Enter your Full Name" required />

        <label>Password</label>
        <div class="password-container">
          <input type="password" id="login-password" name="password" placeholder="Enter your password" required />
          <span class="password-toggle" onclick="togglePassword('login-password', this)">👁️</span>
        </div>

        <button type="submit" name="login">Sign In</button>
      </form>


      <!-- Sign Up Form -->
      <form id="signUpForm" class="login-form" method="POST" action="login.php" style="display:none;">
        <label>Full Name</label>
        <input type="text" name="username" placeholder="Enter your Full Name" required />

        <label>Registration Number</label>
        <input type="text" name="regno" placeholder="Enter your Registration Number" required />

        <label>Email</label>
        <input type="email" name="email" placeholder="Enter your email" required />

        <label>Password</label>
        <div class="password-container">
          <input type="password" id="signup-password" name="password" placeholder="Create a password" required />
          <span class="password-toggle" onclick="togglePassword('signup-password', this)">👁️</span>
        </div>

        <label>Confirm Password</label>
        <div class="password-container">
          <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your password" required />
          <span class="password-toggle" onclick="togglePassword('confirm-password', this)">👁️</span>
        </div>

        <button type="submit" name="register">Sign Up</button>
      </form>
    </div>
  </section>
  
  <footer>
    <p>&copy; 2025 Department of Computer Science, FUTO</p>
    <p>
      <span>Need help? </span>
      <a href="mailto:support@futocsboard.edu.ng" style="color:#fff;text-decoration:underline;">Contact Support</a>
    </p>
    <p>
      <span>Federal University of Technology, Owerri | All rights reserved.</span>
    </p>
  </footer>

  <script src="login.js" defer></script>
  <script src="popup.js"></script>
</body>

<?php if (!empty($_SESSION['message'])): ?>
  <div id="popup" class="popup" style="display:flex;">
    <div class="popup-content">
      <span id="close-popup" class="close">&times;</span>
      <p><?php echo $_SESSION['message']; ?></p>
    </div>
  </div>
  <?php unset($_SESSION['message']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['show_register'])): ?>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      document.getElementById('signInForm').style.display = 'none';
      document.getElementById('signUpForm').style.display = 'block';
    });
  </script>
  <?php unset($_SESSION['show_register']); ?>
<?php endif; ?>


<?php if (isset($_SESSION['redirect_to_home']) && $_SESSION['redirect_to_home'] === true): ?>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Wait 1 second for popup to show, then redirect
    setTimeout(() => {
      window.location.href = "home.php";
    }, 1000);
  });
</script>
<?php unset($_SESSION['redirect_to_home']); endif; ?>

</html>