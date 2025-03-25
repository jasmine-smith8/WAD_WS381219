<?php

// Enable PHP Errors (Otherwise you'll just get a 500 status code)
ini_set('display_errors', 1);

// Put on every page where you only want logged in users
@session_start();
if (!isset($_SESSION['userRole']))
{
    header("Location: login.php");
    die();
}

if ($_SESSION['userRole'] != 'admin')
{
    http_response_code(403);
    die("403 Forbidden: You are not an admin!");
}

// Include the connection file, which contains the $connect objects - this saves us from having to retype the connection code every time
require_once("../php/_connect.php");

// SQL Query
$SQL = "SELECT * FROM courses";

// Run the query using the database connection and the above query
$query = mysqli_query($connect, $SQL);

// Check to see how many rows are returned
if (mysqli_num_rows($query) == 0)
{
    die("There are no courses!");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses Platform</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/admin-pages/styles/adminCourseDashboard.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="./scripts/adminCourseDashScripts.js"></script>
    <script>
        $(document).ready(function() {
            $("#admin-navbar").load("/admin-pages/components/admin-navbar.html");
            $("#user-footer").load("/pages/components/user-footer.html");
        });
    </script>
</head>
<header id="admin-navbar"></header>
<body class="main-content">
    <div class="container">
        <h1>Course Management</h1>
        <hr>

        <table class="table" id="coursesTable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Course Title</th>
                    <th scope="col">Course Description</th>
                    <th scope="col">Course Date</th>
                    <th scope="col">Course Duration</th>
                    <th scope="col">Max Attendees</th>
                    <th scope="col">Options</th>
                </tr>
            </thead>

            <tbody>
                <?php
                // Output the users using fetch_assoc
                // FYI: We could also use fetch_array, but fetch_assoc fetches each row one at a time, which is more efficient for large datasets
                while ($row = mysqli_fetch_assoc($query))
                {
                    $courseID = isset($row['courseID']) ? $row['courseID'] : 'N/A';
                    $courseTitle = isset($row['courseTitle']) ? htmlentities($row['courseTitle']) : 'N/A';
                    $courseDescription = isset($row['courseDescription']) ? htmlentities($row['courseDescription']) : 'N/A';
                    $courseDate = isset($row['courseDate']) ? htmlentities($row['courseDate']) : 'N/A';
                    $courseDuration = isset($row['courseDuration']) ? htmlentities($row['courseDuration']) : 'N/A';
                    $maxAttendees = isset($row['maxAttendees']) ? htmlentities($row['maxAttendees']) : 'N/A';
                    ?>
                <tr>
                    <th scope="row"><i class="course"></i><?= $courseID ?></th>
                    <td><?= $courseTitle ?></td>
                    <td><?= $courseDescription ?></td>
                    <td><?= $courseDate ?></td>
                    <td><?= $courseDuration ," hours" ?></td>
                    <td><?= $maxAttendees ," spaces"?></td>
                    <td>
                        <div class="btn-group">
                            <a href="#" courseID="<?= $row['courseID'] ?>" class="btnDeleteCourse">Delete course</a>
                            <a href="#" courseID="<?= $row['courseID'] ?>" class="btnEditCourse" id="openModal">Edit course</a>
                            <a href="#" courseID="<?= $row['courseID'] ?>" class="btnViewUsers" id="openModalView">View Attendees</a>
                    </div>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <hr>
        <h2>Add New Course</h2>
        <p>Add a new course to the database</p>

        <form method="POST" action="../php/course/createNewCourse.php">
            <div class="grid">
                <label for="courseTitle" class="form-label">Course Title</label>
                <input type="text" class="form-control" id="courseTitle" name="courseTitle">
            </div>
            <div class="grid">
                <label for="courseDesc" class="form-label">Course Description</label>
                <input type="text" class="form-control" id="courseDesc" name="courseDescription">
            </div>
            <div class="grid">
                <label for="courseDate" class="form-label">Course Date</label>
                <input type="date" class="form-control custom-date-picker" id="courseDate" name="courseDate">
            </div>
            <div class="grid">
                <label for="courseDur" class="form-label">Course Duration</label>
                <div class="duration-container">
                    <input type="number" class="form-control" id="courseDur" name="courseDuration" min="1" max="24">
                    <span class="duration-text">hours</span>
                </div>
            </div>
            <div class="grid">
                <label for="maxAttendees" class="form-label">Max Attendees</label>
                <input type="int" class="form-control" id="maxAttendees" name="maxAttendees">
            </div>
            <button type="submit" class="submit-button">Create New Course</button>
        </form>
    </div>
    <script>
    </script>

    <div class="modal" tabindex="-1" id="modalEditCourse">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Course</h5>
                    <button type="button" class="btn-close" id="closeModal"></button>
                </div>

                <form id="formEditCourse">
                    <div class="modal-body">
                        <div class="grid">
                            <label for="editCourseTitle" class="form-label">Course Title</label>
                            <input type="text" class="form-control" id="editCourseTitle" />
                        </div>

                        <div class="grid">
                            <label for="editCourseDesc" class="form-label">Course Description</label>
                            <input type="text" class="form-control" id="editCourseDesc" />
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn" id="closeModalFooter">Close</button>
                        <button type="submit" class="btn">Save Course</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" id="modalViewUsers">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Attendees</h5>
                <button type="button" class="btn-close" id="closeModalViewUsers"></button>
            </div>
            <div class="modal-body">
                <div class="grid">
                    <div id="displayEnrolledUsers">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" id="closeModalFooterViewUsers">Close</button>
            </div>
        </div>
    </div>
</div>
        <div id="user-footer"></div>
        <div id="user-footer"></div>
    </div>
<div id="user-footer"></div>
    </div>
</body>

</html>