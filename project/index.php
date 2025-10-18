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
  <title>Home - Student Information Board</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="dashboard.css">
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
        <li><a href="index.php" class="active">Home</a></li>
        <li><a href="announcements.php">Announcements</a></li>
        <li><a href="events.php">Events</a></li>
        <li><a href="timetable.php">Timetable</a></li>
        <li><a href="logout.php">Logout</a></li>

      </ul>
    </nav>
  </header>
  <section class="hero">
    <h2>Welcome to the Student Information Board</h2>
    <p>Stay updated with departmental announcements, events, and timetables.</p>
    <div class="quick-links">
      <div class="card" onclick="location.href='announcements.php'">
        <img src="https://img.icons8.com/ios-filled/50/228B22/megaphone.png" alt="Announcements" style="width:40px;display:block;margin:0 auto 10px;">
        <span>Announcements</span>
      </div>
      <div class="card" onclick="location.href='events.php'">
        <img src="https://img.icons8.com/ios-filled/50/228B22/calendar.png" alt="Events" style="width:40px;display:block;margin:0 auto 10px;">
        <span>Events</span>
      </div>
      <div class="card" onclick="location.href='timetable.php'">
        <img src="https://img.icons8.com/ios-filled/50/228B22/timeline-week.png" alt="Timetable" style="width:40px;display:block;margin:0 auto 10px;">
        <span>Timetable</span>
      </div>
    </div>
  </section>
  <section class="features" style="background:#f8f8f8;padding:40px 0;">
    <div style="max-width:1100px;margin:0 auto;display:flex;flex-wrap:wrap;gap:40px;justify-content:center;">
      <div style="flex:1 1 250px;min-width:220px;background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.07);padding:30px 20px;margin-bottom:20px;">
        <h3 style="color:#228B22;">Centralized Information</h3>
        <p>All departmental news, events, and timetables in one place for your convenience.</p>
      </div>
      <div style="flex:1 1 250px;min-width:220px;background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.07);padding:30px 20px;margin-bottom:20px;">
        <h3 style="color:#228B22;">Real-Time Updates</h3>
        <p>Stay informed with instant updates on announcements and schedules.</p>
      </div>
      <div style="flex:1 1 250px;min-width:220px;background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.07);padding:30px 20px;margin-bottom:20px;">
        <h3 style="color:#228B22;">Mobile Friendly</h3>
        <p>Access the board from any device, anywhere, anytime.</p>
      </div>
    </div>
  </section>
  <section class="testimonials" style="background:#e6ffe6;padding:40px 0;">
    <div style="max-width:1100px;margin:0 auto;">
      <h2 style="text-align:center;color:#228B22;">What Students Say</h2>
      <div style="display:flex;flex-wrap:wrap;gap:30px;justify-content:center;margin-top:30px;">
        <div style="flex:1 1 250px;min-width:220px;background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.07);padding:25px 18px;">
          <p>"I never miss an announcement anymore. The board is always up to date!"</p>
          <p style="font-weight:bold;margin-top:10px;">- Blessing, 200 Level</p>
        </div>
        <div style="flex:1 1 250px;min-width:220px;background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.07);padding:25px 18px;">
          <p>"The events section helps me plan my semester better."</p>
          <p style="font-weight:bold;margin-top:10px;">- Samuel, 300 Level</p>
        </div>
        <div style="flex:1 1 250px;min-width:220px;background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.07);padding:25px 18px;">
          <p>"I love the mobile experience. Everything is so easy to find."</p>
          <p style="font-weight:bold;margin-top:10px;">- Aisha, 100 Level</p>
        </div>
      </div>
    </div>
  </section>
  <section class="faq" style="background:#fff;padding:40px 0;">
    <div style="max-width:1100px;margin:0 auto;">
      <h2 style="text-align:center;color:#228B22;">Frequently Asked Questions</h2>
      <div style="margin-top:30px;">
        <div style="margin-bottom:25px;">
          <h4 style="color:#006400;margin-bottom:8px;">How do I check announcements?</h4>
          <p>Click the Announcements link in the navigation bar to see the latest updates.</p>
        </div>
        <div style="margin-bottom:25px;">
          <h4 style="color:#006400;margin-bottom:8px;">Can I view the timetable on my phone?</h4>
          <p>Yes! The board is fully responsive and works on all devices.</p>
        </div>
        <div style="margin-bottom:25px;">
          <h4 style="color:#006400;margin-bottom:8px;">How often is the board updated?</h4>
          <p>Announcements and events are updated in real time by the department.</p>
        </div>
      </div>
    </div>
  </section>
  
  <footer>
    <p>&copy; 2025 Department of Computer Science</p>
  </footer>
  <script src="home.js"></script>
</body>
</html>