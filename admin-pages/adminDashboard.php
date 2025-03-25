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
    <link rel="stylesheet" href="/admin-pages/styles/adminDashboard.css">
    <link rel="shortcut icon" href="/pages/img/fire.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="/admin-pages/scripts/adminDashScripts.js"></script>
<script>
    $(document).ready(function() {
        $("#admin-navbar").load("/admin-pages/components/admin-navbar.html");
        $("#user-footer").load("/pages/components/user-footer.html");
    });
</script>
</head>
<body class="main-content">
<header id="admin-navbar"></header>
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
                        <th scope="col">Job Title</th>
                        <th scope="col">Access Level</th>
                        <th scope="col">Options</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    // Output the users using fetch_assoc
                    // FYI: We could also use fetch_array, but fetch_assoc fetches each row one at a time, which is more efficient for large datasets
                    while ($row = mysqli_fetch_assoc($query)) {
                        $userID = $row['userID'];
                        $firstName = $row['firstName'];
                        $lastName = $row['lastName'];
                        $email = $row['email'];
                        $jobTitle = $row['jobTitle'];
                        $userRole = $row['userRole'];
                    ?>
                    <tr>
                        <th scope="row"><i class="user"></i><?= htmlentities($row['userID']) ?></th>
                        <td><?= htmlentities($row['firstName']) ?></td>
                        <td><?= htmlentities($row['lastName']) ?></td>
                        <td><?= htmlentities($row['email']) ?></td>
                        <td><?= htmlentities($row['jobTitle'])?></td>
                        <td><?= htmlentities($row['userRole']) ?></td>
                        <div class="btn-group">
                        <td>
                            <a href="#" userID="<?= $userID ?>" class="btnDeleteUser">Delete User</a>
                            <a href="#" userID="<?= $userID ?>" id="openModal" class="btnEditUser">Edit User</a>
                        </td>
                    </div>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </body>
        <hr>
        <h2>Add New Staff Member</h2>
        <p>Enrol a new member of staff to the database</p>
        <div class="secondary-container">
        <form method="POST" action="../php/user/createNewUser.php">
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
</div>

        <div class="modal" id="modalEditUser">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" id="closeModal">&times;</button>
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
                        <button type="button" class="btn" id="closeModalFooter">Close</button>
                        <button type="submit" class="btn">Save User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="user-footer"></div>
</body>

</html>