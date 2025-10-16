<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  header("Location: login.php");
  exit();
}

$username = $_SESSION['username'];
$firstName = explode(' ', $username)[0]; // Get only first name
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Announcements - Student Info Board</title>
  <link rel="stylesheet" href="announcements.css">
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
        <li><a href="dashboard.php" class="dashboard-link">👤 <?php echo htmlspecialchars($firstName); ?></a></li>
        <li><a href="home.php">Home</a></li>
        <li><a href="announcements.php" class="active">Announcements</a></li>
        <li><a href="events.php">Events</a></li>
        <li><a href="timetable.php">Timetable</a></li>
        <li><a href="logout.php">Logout</a></li>
    </nav>
  </header>
  <section class="hero">
    <h2>Latest Announcements</h2>
    <div class="announcement-list">
      <div class="card">
        <h3>Semester Course Registration</h3>
        <p><strong>Starts:</strong> July 1st, 2025</p>
        <p><strong>Ends:</strong> September 1st, 2025</p>
        <p>Registration for the new semester courses ends next week. Please do well to visit your portal and register your courses.</p>
      </div>
      <div class="card">
        <h3>Exam Timetable Release</h3>
        <p><strong>Date:</strong> September 15, 2025</p>
        <p>The exam timetable has been released on the announcement page. <br/> Read your books so as to not sign any examination malpractice form on anyday</p>
      </div>
    </div>
  </section>
  <section class="features" style="background:#f8f8f8;padding:40px 0;">
    <div style="max-width:1100px;margin:0 auto;display:flex;flex-wrap:wrap;gap:40px;justify-content:center;">
      <div style="flex:1 1 250px;min-width:220px;background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.07);padding:30px 20px;margin-bottom:20px;">
        <h3 style="color:#228B22;">Instant Announcements</h3>
        <p>Receive the latest departmental news and updates as soon as they are posted.</p>
      </div>
      <div style="flex:1 1 250px;min-width:220px;background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.07);padding:30px 20px;margin-bottom:20px;">
        <h3 style="color:#228B22;">Organized Information</h3>
        <p>All announcements are structured and easy to browse for your convenience.</p>
      </div>
      <div style="flex:1 1 250px;min-width:220px;background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.07);padding:30px 20px;margin-bottom:20px;">
        <h3 style="color:#228B22;">Accessible Anywhere</h3>
        <p>Check announcements from your phone, tablet, or computer at any time.</p>
      </div>
    </div>
  </section>
  <section class="testimonials" style="background:#e6ffe6;padding:40px 0;">
    <div style="max-width:1100px;margin:0 auto;">
      <h2 style="text-align:center;color:#228B22;">What Students Say</h2>
      <div style="display:flex;flex-wrap:wrap;gap:30px;justify-content:center;margin-top:30px;">
        <div style="flex:1 1 250px;min-width:220px;background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.07);padding:25px 18px;">
          <p>“I always know when something important is happening in the department.”</p>
          <p style="font-weight:bold;margin-top:10px;">- Musa, 400 Level</p>
        </div>
        <div style="flex:1 1 250px;min-width:220px;background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.07);padding:25px 18px;">
          <p>“The announcement board is my go-to for all updates.”</p>
          <p style="font-weight:bold;margin-top:10px;">- Grace, 200 Level</p>
        </div>
        <div style="flex:1 1 250px;min-width:220px;background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.07);padding:25px 18px;">
          <p>“I like how I can check announcements on my phone.”</p>
          <p style="font-weight:bold;margin-top:10px;">- John, 100 Level</p>
        </div>
      </div>
    </div>
  </section>
  <section class="faq" style="background:#fff;padding:40px 0;">
    <div style="max-width:1100px;margin:0 auto;">
      <h2 style="text-align:center;color:#228B22;">Frequently Asked Questions</h2>
      <div style="margin-top:30px;">
        <div style="margin-bottom:25px;">
          <h4 style="color:#006400;margin-bottom:8px;">How do I get notified of new announcements?</h4>
          <p>Visit this page regularly or enable notifications if available.</p>
        </div>
        <div style="margin-bottom:25px;">
          <h4 style="color:#006400;margin-bottom:8px;">Are old announcements archived?</h4>
          <p>Yes, you can scroll down to see previous announcements.</p>
        </div>
        <div style="margin-bottom:25px;">
          <h4 style="color:#006400;margin-bottom:8px;">Can I access announcements on mobile?</h4>
          <p>Yes, the board is fully responsive and mobile-friendly.</p>
        </div>
      </div>
    </div>
  </section>
  <footer>
    <p>&copy; 2025 Department of Computer Science</p>
  </footer>
  <script src="announcements.js"></script>
</body>
</html>
