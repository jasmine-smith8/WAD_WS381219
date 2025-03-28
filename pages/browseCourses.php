<?php
session_start();
// Enable error reporting
ini_set('display_errors', 1);
// Include the database connection
require_once('../php/_connect.php');

// Check if the userRole is not set and redirect to login page
if (!isset($_SESSION['userRole'])) {
    header("Location: ../login.php");
    exit();
}

// Check if the user is not a user (i.e. admin)
if ($_SESSION['userRole'] != 'user') {
    http_response_code(403);
    die("403 Forbidden: You are not a user!");
}

// Check if the userID is not set in the session
if (!isset($_SESSION['userID'])) {
    die("User ID is not set in the session.");
}

// Get the userID from the session
$userID = $_SESSION['userID'];

// SQL Query
// This query selects all courses and counts the number of users enrolled in each course
// The COUNT function is used to count the number of rows in the userCourse table that have the same courseID
$SQL = "
    SELECT 
        courses.courseID, 
        courses.courseTitle, 
        courses.courseDescription, 
        courses.courseDuration, 
        courses.courseDate, 
        courses.maxAttendees, 
        COUNT(userCourse.userID) AS enrolledUsers
    FROM 
        courses
    LEFT JOIN 
        userCourse 
    ON 
        courses.courseID = userCourse.courseID
    GROUP BY 
        courses.courseID
";

// Run the query using the database connection and the above query
$query = mysqli_query($connect, $SQL);
// Create an array to store the courses
$courses = [];
if ($query) {
    while ($row = mysqli_fetch_assoc($query)) {
        // Add the course to the array
        $courses[] = $row;
    }
}
if (empty($courses)) {
    // If no courses are available, output a message
    echo "<tr><td colspan='8'>No courses available.</td></tr>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Courses</title>
    <link rel="shortcut icon" href="/pages/img/fire.png" type="image/x-icon">
    <link rel="stylesheet" href="/pages/styles/browseCourses.css">
</head>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="/pages/components/scripts/enrollUser.js"></script>
<script src="/pages/components/scripts/loginAlert.js"></script>
</head>
<body>
<header id="user-navbar" aria-label="User Navigation Bar"></header>
<main id="content" aria-label="Main Content Section">
    <div class="container">
        <h1 aria-label="Browse Courses Section">Browse Courses</h1>
        <hr>

        <table class="table" id="coursesTable" aria-label="Courses Table">
            <thead>
                <tr>
        <th scope="col">#</th>
        <th scope="col">Course Title</th>
        <th scope="col">Course Description</th>
        <th scope="col">Course Duration</th>
        <th scope="col">Course Date</th>
        <th scope="col">Enrolled Users</th>
        <th scope="col">Max Attendees</th>
        <th scope="col">Actions</th> 
    </tr>
    </thead>
    <tbody>
                <!-- Output the courses using fetch_assoc -->
                <?php if (!empty($courses)): ?>
                    <?php foreach ($courses as $row): ?>
                        <tr>
                    <th scope="row"><i class="course"></i><?= htmlentities($row['courseID'])?></th>
                    <td><?= htmlentities($row['courseTitle']) ?></td>
                    <td><?= htmlentities($row['courseDescription']) ?></td>
                    <td><?= htmlentities($row['courseDuration']), " hours" ?></td>
                    <td><?= htmlentities($row['courseDate']) ?></td>
                    <td>
                        <?php if ($row['enrolledUsers'] >= $row['maxAttendees']): ?>
                            <span>Full</span>
                        <?php else: ?>
                            <?= htmlentities($row['enrolledUsers']) ?>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlentities($row['maxAttendees']), " spaces" ?></td>
                    <td>
                        <div class="btn-group">
                            <a href="#" courseID="<?= $row['courseID'] ?>" class="btnViewCourse">View Course</a>
                            <!-- Check if the course is full and disable the enroll button if it is -->
                            <a href="#" courseID="<?= $row['courseID'] ?>" class="btnEnrollUser 
                            <?= $row['enrolledUsers'] >= $row['maxAttendees'] ? 'disabled' : '' ?>" 
                            <?= $row['enrolledUsers'] >= $row['maxAttendees'] ? 'aria-disabled="true" style="background-color: grey;"' : '' ?>>Enroll</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>
<footer id="user-footer" aria-label="Footer Section"></footer>
</body>
</html>