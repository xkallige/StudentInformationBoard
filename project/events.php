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
  <title>Events - Student Info Board</title>
  <link rel="stylesheet" href="events.css">
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
        <li><a href="announcements.php">Announcements</a></li>
        <li><a href="events.php" class="active">Events</a></li>
        <li><a href="timetable.php">Timetable</a></li>
        <li><a href="logout.php">Logout</a></li>
  </header>
  <section class="hero">
    <h2>Upcoming Events</h2>
    <div class="event-list">
      <div class="card">
        <h3>CIT 306 Project Presentation</h3>
        <p><strong>Date:</strong> October 18, 2025</p>
        <p><strong>Location:</strong> Online</p>
        <p>A five minutes video. Each group member has only 30 seconds to say what he/she did and how he/she did it. The group leader will be the first to talk.
</p>
      </div>
      <div class="card">
        <h3>Hackathon</h3>
        <p><strong>Date:</strong> October 5, 2025</p>
        <p><strong>Location:</strong> Lab 3</p>
        <p>24-hour coding challenge for all students. </p>
      </div>
    </div>
  </section>
  <section class="features" style="background:#f8f8f8;padding:40px 0;">
    <div style="max-width:1100px;margin:0 auto;display:flex;flex-wrap:wrap;gap:40px;justify-content:center;">
      <div style="flex:1 1 250px;min-width:220px;background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.07);padding:30px 20px;margin-bottom:20px;">
        <h3 style="color:#228B22;">Upcoming Events</h3>
        <p>Never miss an important event—find all departmental activities in one place.</p>
      </div>
      <div style="flex:1 1 250px;min-width:220px;background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.07);padding:30px 20px;margin-bottom:20px;">
        <h3 style="color:#228B22;">Event Reminders</h3>
        <p>Get reminders for upcoming events and deadlines.</p>
      </div>
      <div style="flex:1 1 250px;min-width:220px;background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.07);padding:30px 20px;margin-bottom:20px;">
        <h3 style="color:#228B22;">Easy Participation</h3>
        <p>Sign up and participate in events directly from the board.</p>
      </div>
    </div>
  </section>
  <section class="testimonials" style="background:#e6ffe6;padding:40px 0;">
    <div style="max-width:1100px;margin:0 auto;">
      <h2 style="text-align:center;color:#228B22;">What Students Say</h2>
      <div style="display:flex;flex-wrap:wrap;gap:30px;justify-content:center;margin-top:30px;">
        <div style="flex:1 1 250px;min-width:220px;background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.07);padding:25px 18px;">
          <p>“I always know when the next event is happening.”</p>
          <p style="font-weight:bold;margin-top:10px;">- Seyi, 200 Level</p>
        </div>
        <div style="flex:1 1 250px;min-width:220px;background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.07);padding:25px 18px;">
          <p>“The reminders help me plan my week.”</p>
          <p style="font-weight:bold;margin-top:10px;">- Ifeoma, 300 Level</p>
        </div>
        <div style="flex:1 1 250px;min-width:220px;background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.07);padding:25px 18px;">
          <p>“I love participating in departmental events!”</p>
          <p style="font-weight:bold;margin-top:10px;">- Tunde, 100 Level</p>
        </div>
      </div>
    </div>
  </section>
  <section class="faq" style="background:#fff;padding:40px 0;">
    <div style="max-width:1100px;margin:0 auto;">
      <h2 style="text-align:center;color:#228B22;">Frequently Asked Questions</h2>
      <div style="margin-top:30px;">
        <div style="margin-bottom:25px;">
          <h4 style="color:#006400;margin-bottom:8px;">How do I know about new events?</h4>
          <p>All upcoming events are posted here. Check back regularly for updates.</p>
        </div>
        <div style="margin-bottom:25px;">
          <h4 style="color:#006400;margin-bottom:8px;">Can I get reminders?</h4>
          <p>Yes, reminders are available for major events and deadlines.</p>
        </div>
        <div style="margin-bottom:25px;">
          <h4 style="color:#006400;margin-bottom:8px;">Can I participate in events online?</h4>
          <p>Some events allow online sign-up and participation. Details are provided in each event description.</p>
        </div>
      </div>
    </div>
  </section>
  <footer>
    <p>&copy; 2025 Department of Computer Science</p>
  </footer>
  <script src="events.js"></script>
</body>
</html>
