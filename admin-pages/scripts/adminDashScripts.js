function updateUsersTable() {
    $.ajax({
        // Fetches the user data from the backend
        url: '/../../php/user/fetchUsers.php',
        method: 'GET',
        dataType: 'json',
        success: function(users) {
            let tableBody = $('#usersTable tbody');
            tableBody.empty(); // Clear existing table content

            // Dynamically create the table rows for each user
            users.forEach(user => {
                let row = `
                    <tr>
                        <th scope="row"><img class="rounded-circle"
                            src="https://proficon.appserver.uk/api/identicon/${user.userID}.svg"
                            alt="Icon for User" width="50" height="50"></th>
                        <td>${htmlentities(user.firstName)}</td>
                        <td>${htmlentities(user.lastName)}</td>
                        <td>${htmlentities(user.email)}</td>
                        <td>
                            <div class="btn-group">
                                <a href="#" userID="${user.userID}" class="btn btn-primary btnDeleteUser">Delete User</a>
                                <a href="#" userID="${user.userID}" class="btn btn-primary btnEditUser">Edit User</a>
                            </div>
                        </td>
                    </tr>
                `;
                tableBody.append(row);
            });

            // Reinitialize DataTable
            new DataTable('#usersTable');
        },
    });
}

$(document).ready(function() {
    // Load the navbar and footer components
    $("#admin-navbar").load("/admin-pages/components/admin-navbar.html");
    $("#user-footer").load("/pages/components/user-footer.html");
    // Load the users table
    updateUsersTable();

    // Attach a click event listener to the delete user button
    $(document).on('click','.btnDeleteUser',function(e) {
        e.preventDefault();
    
        let userID = $(this).attr('userID');
    
        Swal.fire({
            title: "Are you sure you want to delete this user?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete them!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Make an AJAX request (using the userID) to the backend and delete the user.
                $.post('/../../php/user/deleteUser.php', { userID: userID }, function (response) {
                    if (response == 'true') {
                        // Reload the page
                        Swal.fire({
                            title: "User Deleted!",
                            text: "The user has been deleted.",
                            icon: "success",
                            heightAuto: false
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: "Something went wrong!",
                            text: response,
                            icon: "error",
                            heightAuto: false
                        });
                    }
                });
            }
        });
    });
    // Create global variable to store the user ID
    let editUserID = 0;
    // Attach a click event listener to the edit user button
    $(document).on('click','.btnEditUser',function(e) {
        e.preventDefault();
    
        let userID = $(this).attr('userID');
    
        // Gets the user data from the backend
        $.post('/../../php/user/fetchUserEditData.php', { userID: userID }, function (res) {
            let user = JSON.parse(res);
            // Populate the form fields with the user data
            $('#txtEditFirstName').val(user.firstName);
            $('#txtEditLastName').val(user.lastName);
            // Store the userID as a global variable
            editUserID = userID;

           // Show the modal
            $('#modalEditUser').modal('show');
        });
    });
    
    $('#formEditUser').submit(function (e) {
        e.preventDefault();
        // Get the user data from the form fields
        let firstName = $('#txtEditFirstName').val();
        let lastName = $('#txtEditLastName').val();
    
        // Sets the data to be sent to the backend
        $.post('/../../php/user/updateUserEditData.php',
            {
                // Send the userID and the new data
                userID: editUserID,
                firstName: firstName,
                lastName: lastName 
            },
            function (response) {
                if (response == 'true') {
                    Swal.fire({
                        title: "User Updated!",
                        text: "The user has been updated.",
                        icon: "success",
                        heightAuto: false
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: "Something went wrong!",
                        text: response,
                        icon: "error",
                        heightAuto: false
                    });
                }
        });
    });
});

// Function to convert special characters to HTML entities to prevent XSS attacks
function htmlentities(str) {
    return $('<div/>').text(str).html();
}

