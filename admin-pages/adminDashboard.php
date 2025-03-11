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
$SQL = "SELECT * FROM users";

// Run the query using the database connection and the above query
$query = mysqli_query($connect, $SQL);

// Check to see how many rows are returned
if (mysqli_num_rows($query) == 0)
{
    die("There are no users!");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Platform</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/admin-pages/styles/adminDashboard.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script>
    $(document).ready(function() {
        $("#admin-navbar").load("/admin-pages/components/admin-navbar.html");
        $("#user-footer").load("./pages/components/user-footer.html");
    });
  </script>
</head>
<body class="main-content">
    <header id="admin-navbar"></header>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="./scripts/adminDashScripts.js"></script>
    <div class="container">
        <h1>Staff Management</h1>
        <hr>

        <table class="table" id="usersTable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Access Level</th>
                    <th scope="col">Options</th>
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
                    <div class="btn-group">
                        <td>
                            <a href="#" userID="<?= $row['userID'] ?>" class="btn btn-primary btnDeleteUser">Delete User</a>
                            <a href="#" userID="<?= $row['userID'] ?>" class="btn btn-primary btnEditUser">Edit User</a>
                        </td>
                    </div>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <hr>
        <h2>Add New Staff Member</h2>
        <p>Enrol a new member of staff to the database</p>

        <form method="POST" action="../php/createNewUser.php">
        <div class="grid">
            <label for="txtemail" class="form-label">Email</label>
            <input type="text" class="form-control" id="txtemail" name="txtemail">
        </div>
        <div class="grid">
            <label for="txtFirstName" class="form-label">First Name</label>
            <input type="text" class="form-control" id="txtFirstName" name="txtFirstName">
        </div>
        <div class="grid">
            <label for="txtLastName" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="txtLastName" name="txtLastName">
        </div>
        <div class="grid">
            <label for="txtPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="txtPassword" name="txtPassword">
        </div>
        <div class="grid">
            <label for="txtJobTitle" class="form-label">Job Title</label>
            <input type="text" class="form-control" id="txtJobTitle" name="txtJobTitle">
        </div>
        <div class="grid">
            <label for="userRole" class="form-label">User Role</label>
            <select class="form-control" id="userRole" name="userRole">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <button type="submit" class="submit-button">Create New User</button>
    </form>
    </div>

    <div class="modal" tabindex="-1" id="modalEditUser">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="formEditUser">
                    <div class="modal-body">
                        <div class="grid">
                            <label for="txtEditFirstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="txtEditFirstName">
                        </div>

                        <div class="grid">
                            <label for="txtEditLastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="txtEditLastName">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save User</button>
                    </div>
                </form>
            </div>
        </div>
        <div id="user-footer"></div>
    </div>
</body>

</html>