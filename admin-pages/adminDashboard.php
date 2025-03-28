<?php
@session_start();
// Enable PHP Errors 
ini_set('display_errors', 1);

// Include the database connection
require_once("../php/_connect.php");

// Check if the user is logged in and redirect to the login page if not
if (!isset($_SESSION['userRole']))
{
    header("Location: login.php");
    die();
}

// Check if the user is not an admin
if ($_SESSION['userRole'] != 'admin')
{
    // If the user is not an admin, return a 403 Forbidden error
    http_response_code(403);
    die("403 Forbidden: You are not an admin!");
}

// SQL Query to select all user details
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
<header id="admin-navbar" aria-label="Admin Navigation Bar"></header>
<body class="main-content">
    <div class="container">
        <h1 aria-label="Staff Management Section">Staff Management</h1>
        <hr>
            <table class="table" id="usersTable" aria-label="Users Table">
                <thead>
                    <tr>
                        <th scope="col" aria-label="User ID Column">#</th>
                        <th scope="col" aria-label="First Name Column">First Name</th>
                        <th scope="col" aria-label="Last Name Column">Last Name</th>
                        <th scope="col" aria-label="Email Column">Email</th>
                        <th scope="col" aria-label="Job Title Column">Job Title</th>
                        <th scope="col" aria-label="Access Level Column">Access Level</th>
                        <th scope="col" aria-label="Options Column">Options</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    // Output the users using fetch_assoc
                    while ($row = mysqli_fetch_assoc($query)) {
                        $userID = $row['userID'];
                        $firstName = $row['firstName'];
                        $lastName = $row['lastName'];
                        $email = $row['email'];
                        $jobTitle = $row['jobTitle'];
                        $userRole = $row['userRole'];
                    ?>
                    <tr>
                        <!-- Output the user details -->
                        <th scope="row" aria-label="User ID"><?= htmlentities($row['userID']) ?></th>
                        <td aria-label="First Name"><?= htmlentities($row['firstName']) ?></td>
                        <td aria-label="Last Name"><?= htmlentities($row['lastName']) ?></td>
                        <td aria-label="Email"><?= htmlentities($row['email']) ?></td>
                        <td aria-label="Job Title"><?= htmlentities($row['jobTitle'])?></td>
                        <td aria-label="Access Level"><?= htmlentities($row['userRole']) ?></td>
                        <div class="btn-group">
                        <td aria-label="User Options">
                            <a href="#" userID="<?= $userID ?>" class="btnDeleteUser" aria-label="Delete User Button">Delete User</a>
                            <a href="#" userID="<?= $userID ?>" id="openModal" class="btnEditUser" aria-label="Edit User Button">Edit User</a>
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
        <h2 aria-label="Add New Staff Member Section">Add New Staff Member</h2>
        <p aria-label="Add New Staff Member Description">Enroll a new member of staff to the database</p>
        <div class="secondary-container">
        <!-- POST request to add new user to the db -->
        <form method="POST" action="../php/user/createNewUser.php" aria-label="Add New Staff Member Form">
        <div class="grid">
            <label for="txtemail" class="form-label">Email</label>
            <input type="email" class="form-control" id="txtemail" name="txtemail" aria-label="Email Input">
        </div>
        <div class="grid">
            <label for="txtFirstName" class="form-label">First Name</label>
            <input type="text" class="form-control" id="txtFirstName" name="txtFirstName" aria-label="First Name Input">
        </div>
        <div class="grid">
            <label for="txtLastName" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="txtLastName" name="txtLastName" aria-label="Last Name Input">
        </div>
        <div class="grid">
            <label for="txtPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="txtPassword" name="txtPassword" aria-label="Password Input">
        </div>
        <div class="grid">
            <label for="txtJobTitle" class="form-label">Job Title</label>
            <input type="text" class="form-control" id="txtJobTitle" name="txtJobTitle" aria-label="Job Title Input">
        </div>
        <div class="grid">
            <label for="userRole" class="form-label">User Role</label>
            <select class="form-control" id="userRole" name="userRole" aria-label="User Role Dropdown">
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <button type="submit" class="submit-button" aria-label="Create New User Button">Create New User</button>
    </form>
    </div>
</div>
<!-- Modal for editing user details -->
    <div class="modal" id="modalEditUser" aria-label="Edit User Modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" aria-label="Edit User Modal Title">Edit User</h5>
                    <button type="button" class="btn-close" id="closeModal" data-bs-dismiss="modal" aria-label="Close Edit User Modal"></button>
                </div>

                <form id="formEditUser" aria-label="Edit User Form">
                    <div class="modal-body">
                        <div class="grid">
                            <label for="txtEditFirstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="txtEditFirstName" aria-label="Edit First Name Input">
                        </div>

                        <div class="grid">
                            <label for="txtEditLastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="txtEditLastName" aria-label="Edit Last Name Input">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn" id="closeModalFooter" data-bs-dismiss="modal" aria-label="Close Edit User Modal Footer">Close</button>
                        <button type="submit" class="btn" aria-label="Save Edited User Button">Save User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <footer id="user-footer" aria-label="Footer Section" role="footer"></footer>
</body>
</html>