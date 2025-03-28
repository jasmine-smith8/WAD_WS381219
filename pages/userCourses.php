<?php
session_start();

// Enable error reporting
ini_set('display_errors', 1);

// Include the database connection
require_once('../php/_connect.php');

// Check if the user is not logged in
if (!isset($_SESSION['userRole'])) {
    header("Location: ../login.php");
    exit();
}
// Check if the user is not a user (i.e. admin)
if ($_SESSION['userRole'] != 'user') {
    http_response_code(403);
    die("403 Forbidden: You are not a user!");
}
// Check if the user ID is not set in the session
if (!isset($_SESSION['userID'])) {
    die("User ID is not set in the session.");
}

// Get the user ID from the session
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
        userCourse.userID = ?
";

// Prepare the statement
$stmt = $connect->prepare($SQL);

// Bind the parameter
$stmt->bind_param("i", $userID);

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();
$courses = [];
while ($row = $result->fetch_assoc()) {
    $courses[] = $row;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses</title>
    <link rel="shortcut icon" href="/pages/img/fire.png" type="image/x-icon">
    <link rel="stylesheet" href="/pages/styles/userCourses.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/pages/components/scripts/enrollUser.js"></script>
</head>
<body>
<header id="user-navbar" aria-label="User Navigation Bar"></header>
<main id="content" aria-label="Main Content Section">
    <div class="container">
        <h1 aria-label="My Enrolled Courses Section">My Enrolled Courses</h1>
        <hr>
        <table class="table" id="myCoursesTable" aria-label="Enrolled Courses Table">
            <thead>
                <tr>
                    <th scope="col" aria-label="Course ID Column">#</th>
                    <th scope="col" aria-label="Course Title Column">Course Title</th>
                    <th scope="col" aria-label="Course Description Column">Course Description</th>
                    <th scope="col" aria-label="Course Duration Column">Course Duration</th>
                    <th scope="col" aria-label="Course Date Column">Course Date</th>
                    <th scope="col" aria-label="Actions Column">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($courses)): ?>
                    <?php foreach ($courses as $row): ?>
                        <tr>
                            <th scope="row" aria-label="Course ID"><?= htmlentities($row['courseID']) ?></th>
                            <td aria-label="Course Title"><?= htmlentities($row['courseTitle']) ?></td>
                            <td aria-label="Course Description"><?= htmlentities($row['courseDescription']) ?></td>
                            <td aria-label="Course Duration"><?= htmlentities($row['courseDuration']) ?> hours</td>
                            <td aria-label="Course Date"><?= htmlentities($row['courseDate']) ?></td>
                            <td aria-label="Actions">
                                <div class="btn-group">
                                    <a href="#" courseID="<?= $row['courseID'] ?>" class="btnViewCourse" id="openModal" aria-label="View Course Button">View Course</a>
                                    <a href="#" courseID="<?= $row['courseID'] ?>" class="btnUnenrollUser" aria-label="Unenroll Button">Unenroll</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" aria-label="No Enrolled Courses Message">You are not enrolled in any upcoming courses.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>
<footer id="user-footer" aria-label="Footer Section" role="footer"></footer>
</body>
</html>