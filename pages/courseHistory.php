<?php
session_start();
// Enable error reporting
ini_set('display_errors', 1);

// Include the database connection
require_once('../php/_connect.php');

// Check if the user is logged in
if (!isset($_SESSION['userRole'])) {
    header("Location: ../login.php");
    exit();
}

// Check if the user is not a user (i.e. admin)
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
    <title>Course History</title>
    <link rel="shortcut icon" href="/pages/img/fire.png" type="image/x-icon">
    <link rel="stylesheet" href="/pages/styles/userCourses.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/pages/components/scripts/courseHistory.js"></script>
</head>
<body>
<header id="user-navbar" aria-label="User Navbar Section" role="navbar"></header>
<main id="content">
    <div class="container">
        <h1>Course History</h1>
        <hr>
        <table class="table" id="coursesTable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Course Title</th>
                    <th scope="col">Course Description</th>
                    <th scope="col">Course Duration</th>
                    <th scope="col">Course Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($courses)): ?>
                    <?php foreach ($courses as $row): ?>
                        <tr>
                            <th scope="row"><?= htmlentities($row['courseID']) ?></th>
                            <td><?= htmlentities($row['courseTitle']) ?></td>
                            <td><?= htmlentities($row['courseDescription']) ?></td>
                            <td><?= htmlentities($row['courseDuration']) ?> hours</td>
                            <td><?= htmlentities($row['courseDate']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No course history available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>
<footer id="user-footer" aria-label="footer" role="footer"></footer>
</body>
</html>