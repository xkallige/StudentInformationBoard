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
  <title>Timetable - Student Info Board</title>
  <link rel="stylesheet" href="timetable.css">
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
        <li><a href="index.php">Home</a></li>
        <li><a href="announcements.php">Announcements</a></li>
        <li><a href="events.php">Events</a></li>
        <li><a href="timetable.php" class="active">Timetable</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>
  <section class="hero">
    <h2>Class Timetable</h2>
    <table class="timetable">
      <thead>
        <tr>
          <th></th>
          <th>8:30 - 9:30</th>
          <th>9:30 - 10:30</th>
          <th>10:30 - 11:30</th>
          <th>11:30 - 12:30</th>
          <th>12:30 - 1:30</th>
          <th>1:30 - 2:30</th>
          <th>2:30 - 3:30</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Monday</td>
          <td>CSC 302</td>
          <td>CSC 302</td>
          <td>CSC 304</td>
          <td>CSC 304</td>
          <td>CIT 302</td>
          <td>CIT 302</td>
          <td></td>
        </tr>
        <tr>
          <td>Tuesday</td>
          <td></td>
          <td></td>
          <td>CSC 310</td>
          <td>CSC 310</td>
          <td></td>
          <td>CSC 308</td>
          <td></td>
        </tr>
        <tr>
          <td>Wednesday</td>
          <td>CSC 306</td>
          <td>CSC 302</td>
          <td>CSC 302</td>
          <td>CSC 304</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>Thursday</td>
          <td></td>
          <td>CSC 310</td>
          <td>CSC 310</td>
          <td>CSC 304</td> 
          <td>CIT 306</td>
          <td>CIT 306</td>
          <td></td>
        </tr>
        <tr>
          <td>Friday</td>
          <td></td>
          <td>CSC 310</td>
          <td></td>
          <td>CSC 306</td>
          <td>CSC 306</td>
          <td>CIT 304</td>
          <td>CIT 304</td>
        </tr>
      </tbody>
    </table>
    <h2>2024/2025 Exam Timetable (Week One)</h2>
    <table class="timetable">
      <thead>
        <tr>
          <th></th>
          <th>9AM - 12PM</th>
          <th>1PM - 4PM</th>
          <th>Venue</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Monday 15th <br/> September, 2025</td>
          <td></td>
          <td>CIT 302</td>
          <td>IMT LH 1, 2 & 3<br/>SMAT AUD</td>
        </tr>
        <tr>
          <td>Tuesday 16th <br/> September, 2025</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>Wednesday 17th <br/> September, 2025</td>
          <td>CIT 304</td>
          <td></td>
          <td>IMT LH 1, 2 & 3<br/>SMAT AUD</td>
        </tr>
        <tr>
          <td>Thursday 18th <br/> September, 2025</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>Friday 19th <br/> September, 2025</td>
          <td>ENS 302</td>
          <td>CIT 306</td>
          <td>IMT LH 1, 2 & 3<br/>SMAT AUD</td>
        </tr>
        <tr>
          <td>Saturday 20th <br/> September, 2025</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
    </table>
    <h2>2024/2025 Exam Timetable (Week Two)</h2>
    <table class="timetable">
      <thead>
        <tr>
          <th></th>
          <th>9AM - 12PM</th>
          <th>1PM - 4PM</th>
          <th>Venue</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Monday 22nd <br/> September, 2025</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>Tuesday 23rd <br/> September, 2025</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>Wednesday 24th <br/> September, 2025</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>Thursday 25th <br/> September, 2025</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>Friday 26th <br/> September, 2025</td>
          <td>CSC 302</td>
          <td></td>
          <td>IMT LH 1, 2 & 3<br/>SMAT AUD</td>
        </tr>
        <tr>
          <td>Saturday 27th <br/> September, 2025</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
      </tbody>
    </table>
    <h2>2024/2025 Exam Timetable (Week Three)</h2>
    <table class="timetable">
      <thead>
        <tr>
          <th></th>
          <th>9AM - 12PM</th>
          <th>1PM - 4PM</th>
          <th>Venue</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Monday 15th <br/> September, 2025</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>Tuesday 16th <br/> September, 2025</td>
          <td>CSC 310</td>
          <td></td>
          <td>IMT LH 1, 2 & 3<br/>SMAT AUD</td>
        </tr>
        <tr>
          <td>Wednesday 17th <br/> September, 2025</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>Thursday 18th <br/> September, 2025</td>
          <td></td>
          <td>CSC 304</td>
          <td>IMT LH 1, 2 & 3<br/>SMAT AUD</td>
        </tr>
        <tr>
          <td>Friday 19th <br/> September, 2025</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>Saturday 20th <br/> September, 2025</td>
          <td>CSC 306</td>
          <td></td>
          <td>IMT LH 1, 2 & 3<br/>SMAT AUD</td>
        </tr>
      </tbody>
    </table>
  </section>
  <section class="features" style="background:#f8f8f8;padding:40px 0;">
    <div style="max-width:1100px;margin:0 auto;display:flex;flex-wrap:wrap;gap:40px;justify-content:center;">
      <div style="flex:1 1 250px;min-width:220px;background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.07);padding:30px 20px;margin-bottom:20px;">
        <h3 style="color:#228B22;">Easy Timetable Access</h3>
        <p>View your class schedule anytime, anywhere, on any device.</p>
      </div>
      <div style="flex:1 1 250px;min-width:220px;background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.07);padding:30px 20px;margin-bottom:20px;">
        <h3 style="color:#228B22;">Up-to-date Schedules</h3>
        <p>All timetable changes are reflected instantly for your convenience.</p>
      </div>
      <div style="flex:1 1 250px;min-width:220px;background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.07);padding:30px 20px;margin-bottom:20px;">
        <h3 style="color:#228B22;">Printable Format</h3>
        <p>Download or print your timetable for offline reference.</p>
      </div>
    </div>
  </section>
  <section class="testimonials" style="background:#e6ffe6;padding:40px 0;">
    <div style="max-width:1100px;margin:0 auto;">
      <h2 style="text-align:center;color:#228B22;">What Students Say</h2>
      <div style="display:flex;flex-wrap:wrap;gap:30px;justify-content:center;margin-top:30px;">
        <div style="flex:1 1 250px;min-width:220px;background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.07);padding:25px 18px;">
          <p>“I always know where my next class is.”</p>
          <p style="font-weight:bold;margin-top:10px;">- Uche, 200 Level</p>
        </div>
        <div style="flex:1 1 250px;min-width:220px;background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.07);padding:25px 18px;">
          <p>“I know when my eaxm starts and when and the courses i have each day, Thanks to this website board.”</p>
          <p style="font-weight:bold;margin-top:10px;">- Maryann, 300 Level</p>
        </div>
        <div style="flex:1 1 250px;min-width:220px;background:#fff;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.07);padding:25px 18px;">
          <p>“I like that I can check my schedule on my phone.”</p>
          <p style="font-weight:bold;margin-top:10px;">- David, 100 Level</p>
        </div>
      </div>
    </div>
  </section>
  <section class="faq" style="background:#fff;padding:40px 0;">
    <div style="max-width:1100px;margin:0 auto;">
      <h2 style="text-align:center;color:#228B22;">Frequently Asked Questions</h2>
      <div style="margin-top:30px;">
        <div style="margin-bottom:25px;">
          <h4 style="color:#006400;margin-bottom:8px;">How do I print my timetable?</h4>
          <p>Use your browser’s print function or download the timetable as a PDF.</p>
        </div>
        <div style="margin-bottom:25px;">
          <h4 style="color:#006400;margin-bottom:8px;">Are timetable changes updated here?</h4>
          <p>Yes, all changes are reflected instantly on this page.</p>
        </div>
        <div style="margin-bottom:25px;">
          <h4 style="color:#006400;margin-bottom:8px;">Can I view the timetable on my phone?</h4>
          <p>Yes, the timetable is fully responsive and mobile-friendly.</p>
        </div>
      </div>
    </div>
  </section>
  <footer>
    <p>&copy; 2025 Department of Computer Science</p>
  </footer>
  <script src="timetable.js"></script>
</body>
</html>
