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
    <title>Course History</title>
</head>
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
            <h1>Course History</h1>
            <hr>

            <table class="table" id="coursesTable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Course Title</th>
                        <th scope="col">Date Completed</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    // Output the users using fetch_assoc
                    // FYI: We could also use fetch_array, but fetch_assoc fetches each row one at a time, which is more efficient for large datasets
                    while ($row = mysqli_fetch_assoc($query))
                    {
                    ?>
                    <tr>
                        <th scope="row"><i class="fa-solid fa-user"></i><?= $row['userID'] ?></th>
                        <td><?= htmlentities($row['firstName']) ?></td>
                        <td><?= htmlentities($row['lastName']) ?></td>
                        <td><?= htmlentities($row['email']) ?></td>
                        <td><?= htmlentities($row['userRole']) ?></td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </main>
    </body>
</html>