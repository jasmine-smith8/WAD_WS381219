<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['userRole'])) {
    header("Location: login.php");
    exit();
}
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
  <link rel="stylesheet" href="/pages/styles/userDashboard.css">
  <link rel="stylesheet" href="/pages/components/user-navbar.css">
  <link rel="stylesheet" href="/pages/components/user-footer.css">
  <title>HateHire User Platform</title>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="/pages/components/scripts/userDashScripts.js"></script>
</head>
<body>
<header id="user-navbar"></header>
  <main id="content">
    <div class="container">
      <div class="title">
        <h3 class="scrolling-title">
          Welcome to <strong>HateHire</strong>, where the work is as unique as you are!
        </h3>
      </div>
      <div class="customer-testimony">
        <h1>Customer Testimonies</h1>
      </div>
      <div class="grid-container">
        <div class="card">
          <p>"I hired HateHire for my ex’s wedding. Their subtle-yet-devastating presence ruined the vibe perfectly."</p>
          <p><strong>~ Jessica, 28</strong></p>
        </div>
        <div class="card">
          <p>"My coworker got an undeserved promotion, so I brought in HateHire to passive-aggressively roast them at every meeting. Worth every penny."</p>
          <p><strong>~ Mike, 33</strong></p>
        </div>
        <div class="card">
          <p>"HateHire helped me professionally despise my neighbor. Now, they mysteriously park a block away. Incredible results!"</p>
          <p><strong>~ Erin, 41</strong></p>
        </div>
        <div class="card">
          <p>"I needed someone to roll their eyes at my cousin’s art exhibit. HateHire delivered. Masterful work."</p>
          <p><strong>~ David, 29</strong></p>
        </div>
        <div class="card">
          <p>"My high school rival was getting *too* successful. HateHire helped me bring them down a peg—discreetly, of course."</p>
          <p><strong>~ Alex, 35</strong></p>
        </div>
        <div class="card">
          <p>"HateHire made my enemy’s birthday party a **memorable** disaster. The whispered rumors alone? *Chef’s kiss.*"</p>
          <p><strong>~ Taylor, 30</strong></p>
        </div>
        <div class="card">
          <p>"I just wanted someone to glare at my least favorite coworker during a work function. HateHire didn’t disappoint."</p>
          <p><strong>~ Chris, 27</strong></p>
        </div>
        <div class="card">
          <p>"Why confront someone yourself when you can outsource the disdain? HateHire gave my nemesis the side-eye of a lifetime."</p>
          <p><strong>~ Vanessa, 32</strong></p>
        </div>
        <div class="card">
          <p>"I hired HateHire for a wedding where I wasn’t the Maid of Honor. Let’s just say… no one will forget the ‘technical difficulties’ anytime soon."</p>
          <p><strong>~ Rachel, 29</strong></p>
        </div>
        <div class="card">
          <p>"I hired HateHire for a wedding where I wasn’t the Maid of Honor. Let’s just say… no one will forget the ‘technical difficulties’ anytime soon."</p>
          <p><strong>~ Rachel, 29</strong></p>
        </div>
      </div>
    </div>
    <div class="subheading">
      <h4>Ready to get started?</h4>
    </div>
    <div class="body-content">
      <p>With our fantastic training program, you can be a professional hater in no time!</p>
      <p>Head over to <i>Browse Courses</i> to check out our excellent range of courses, all curated by professionals.</p>
    </div>
    <div class="subheading">
      <h4>Check out some of our happy customers!</h4>
    </div>
    <div class="gallery">
      <img src="/pages/img/person-1.jpg" alt="Person 1">
      <img src="/pages/img/person-2.jpg" alt="Person 2">
      <img src="/pages/img/person-3.jpg" alt="Person 3">
    </div>
    <div id="user-footer"></div>
  </main>
</body>
</html>