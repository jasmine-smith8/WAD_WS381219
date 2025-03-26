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
require_once('../php/_connect.php');
// SQL Query
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
$courses = [];
if ($query) {
    while ($row = mysqli_fetch_assoc($query)) {
        $courses[] = $row;
    }
}
if (empty($courses)) {
    echo "<tr><td colspan='8'>No courses available.</td></tr>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Courses</title>
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
<script>
    const userID = "<?php echo isset($_SESSION['userID']) ? $_SESSION['userID'] : ''; ?>";
    if (userID) {
        sessionStorage.setItem('userID', userID);
    } else {
        console.error('User ID is not set in the session.');
    }
</script>
  <script>
    $(document).ready(function() {
        $("#coursesTable").DataTable();
        $("#user-navbar").load("/pages/components/user-navbar.html");
        $("#user-footer").load("/pages/components/user-footer.html");
    });
  </script>
</head>
<body>
<header id="user-navbar"></header>
  <main id="content">
    <div class="container">
            <h1>Browse Courses</h1>
            <hr>

    <table class="table" id="coursesTable">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Course Title</th>
        <th scope="col">Course Description</th>
        <th scope="col">Course Duration</th>
        <th scope="col">Course Date</th>
        <th scope="col">enrolled Users</th>
        <th scope="col">Max Attendees</th>
        <th scope="col">Actions</th> 
    </tr>
    </thead>
    <tbody>
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
                            <button class="btn" disabled>Full</button>
                        <?php else: ?>
                            <?= htmlentities($row['enrolledUsers']) ?>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlentities($row['maxAttendees']), " spaces" ?></td>
                    <td>
                        <div class="btn-group">
                            <a href="#" courseID="<?= $row['courseID'] ?>" class="btnViewCourse">View Course</a>
                            <a href="#" courseID="<?= $row['courseID'] ?>" class="btnEnrollUser">Enroll</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8">No courses available.</td>
            </tr>
        <?php endif; ?>
                </tbody>
            </table>
            </div>
            <div id="user-footer"></div>
        </main>
    </body>
</html>