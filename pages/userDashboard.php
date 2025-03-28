<?php
session_start();

// Enable error reporting
ini_set('display_errors', 1);

// Check if the user is logged in
if (!isset($_SESSION['userRole'])) {
    header("Location: login.php");
    exit();
}
// Check if the user is not a user (i.e. an admin)
if ($_SESSION['userRole'] != 'user') {
    http_response_code(403);
    die("403 Forbidden: You are not a user!");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="/pages/img/fire.png" type="image/x-icon">
  <link rel="stylesheet" href="/pages/styles/userDashboard.css">
  <link rel="stylesheet" href="/pages/components/user-navbar.css">
  <link rel="stylesheet" href="/pages/components/user-footer.css">
  <title>HateHire User Platform</title>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="/pages/components/scripts/userDashScripts.js"></script>
</head>
<body>
<header id="user-navbar" aria-label="User Navigation Bar"></header>
  <main id="content" aria-label="Main Content Section">
    <div class="container">
      <div class="title">
        <h3 class="scrolling-title" aria-label="Welcome Message">
          Welcome to <strong>HateHire</strong>, where the work is as unique as you are!
        </h3>
      </div>
      <div class="customer-testimony" aria-label="Customer Testimonies Section">
        <h1>Customer Testimonies</h1>
      </div>
      <div class="grid-container" aria-label="Testimonies Grid">
        <div class="card" aria-label="Testimony Card">
          <p>"I hired HateHire for my ex’s wedding. Their subtle-yet-devastating presence ruined the vibe perfectly."</p>
          <p><strong>~ Jessica, 28</strong></p>
        </div>
        <div class="card" aria-label="Testimony Card">
          <p>"My coworker got an undeserved promotion, so I brought in HateHire to passive-aggressively roast them at every meeting. Worth every penny."</p>
          <p><strong>~ Mike, 33</strong></p>
        </div>
        <div class="card" aria-label="Testimony Card">
          <p>"HateHire helped me professionally despise my neighbor. Now, they mysteriously park a block away. Incredible results!"</p>
          <p><strong>~ Erin, 41</strong></p>
        </div>
        <div class="card" aria-label="Testimony Card">
          <p>"I needed someone to roll their eyes at my cousin’s art exhibit. HateHire delivered. Masterful work."</p>
          <p><strong>~ David, 29</strong></p>
        </div>
        <div class="card" aria-label="Testimony Card">
          <p>"My high school rival was getting *too* successful. HateHire helped me bring them down a peg—discreetly, of course."</p>
          <p><strong>~ Alex, 35</strong></p>
        </div>
        <div class="card" aria-label="Testimony Card">
          <p>"HateHire made my enemy’s birthday party a **memorable** disaster. The whispered rumors alone? *Chef’s kiss.*"</p>
          <p><strong>~ Taylor, 30</strong></p>
        </div>
        <div class="card" aria-label="Testimony Card">
          <p>"I just wanted someone to glare at my least favorite coworker during a work function. HateHire didn’t disappoint."</p>
          <p><strong>~ Chris, 27</strong></p>
        </div>
        <div class="card" aria-label="Testimony Card">
          <p>"Why confront someone yourself when you can outsource the disdain? HateHire gave my nemesis the side-eye of a lifetime."</p>
          <p><strong>~ Vanessa, 32</strong></p>
        </div>
        <div class="card" aria-label="Testimony Card">
          <p>"I hired HateHire for a wedding where I wasn’t the Maid of Honor. Let’s just say… no one will forget the ‘technical difficulties’ anytime soon."</p>
          <p><strong>~ Rachel, 29</strong></p>
        </div>
        <div class="card" aria-label="Testimony Card">
          <p>"HateHire has saved me from so many uncomfortable interactions, whilst still providing me with the satifaction of the outcome. 5 stars!"</p>
          <p><strong>~ Jim, 85</strong></p>
        </div>
      </div>
    </div>
    <div class="subheading" aria-label="Ready to Get Started Section">
      <h4>Ready to get started?</h4>
    </div>
    <div class="body-content" aria-label="Training Program Section">
      <p>With our fantastic training program, you can be a professional hater in no time!</p>
      <p>Head over to <i>Browse Courses</i> to check out our excellent range of courses, all curated by professionals.</p>
    </div>
    <div class="subheading" aria-label="Happy Customers Section">
      <h4>Check out some of our happy customers!</h4>
    </div>
    <div class="gallery" aria-label="Customer Gallery">
      <img src="/pages/img/person-1.jpg" alt="Person 1" aria-label="Customer Image 1">
      <img src="/pages/img/person-2.jpg" alt="Person 2" aria-label="Customer Image 2">
      <img src="/pages/img/person-3.jpg" alt="Person 3" aria-label="Customer Image 3">
    </div>
    <footer id="user-footer" aria-label="Footer Section" role="footer"></footer>
  </main>
</body>
</html>