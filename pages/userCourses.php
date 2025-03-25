<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['userRole'])) {
    header("Location: ../login.php");
    exit();
}

if ($_SESSION['userRole'] != 'user') {
    http_response_code(403);
    die("403 Forbidden: You are not a user!");
}

if (!isset($_SESSION['userID'])) {
    die("User ID is not set in the session.");
}

require_once('../php/_connect.php');

$userID = $_SESSION['userID'];

// SQL Query to fetch courses the user is enrolled in
$SQL = "
    SELECT 
        courses.courseID, 
        courses.courseTitle, 
        courses.courseDescription, 
        courses.courseDuration, 
        courses.courseDate
    FROM 
        courses
    INNER JOIN 
        userCourse 
    ON 
        courses.courseID = userCourse.courseID
    WHERE 
        userCourse.userID = '$userID'
";

$query = mysqli_query($connect, $SQL);
$courses = [];
if ($query) {
    while ($row = mysqli_fetch_assoc($query)) {
        $courses[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses</title>
    <link rel="stylesheet" href="/pages/styles/userCourses.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $("#user-navbar").load("/pages/components/user-navbar.html");
            $("#user-footer").load("/pages/components/user-footer.html");
        });
    </script>
</head>
<body>
<header id="user-navbar"></header>
<main id="content">
    <div class="container">
        <h1>My Enrolled Courses</h1>
        <hr>
        <table class="table" id="coursesTable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Course Title</th>
                    <th scope="col">Course Description</th>
                    <th scope="col">Course Duration</th>
                    <th scope="col">Course Date</th>
                    <th scope="col">Actions</th>
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
                            <td>
                                <div class="btn-group">
                                    <a href="#" courseID="<?= $row['courseID'] ?>" class="btnViewCourse" id="openModal">View Course</a>
                                    <a href="#" courseID="<?= $row['courseID'] ?>" class="btnUnEnrolUser">Unenrol</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">You are not enrolled in any courses.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>
<footer id="user-footer"></footer>
</body>
</html>