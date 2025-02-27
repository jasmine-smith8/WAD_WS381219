// Call to reload users table
function updateUsersTable() {
    // AJAX
    // Get JSON
    // Convert to HTML table
    // Update the DOM

    new DataTable('#usersTable');
}

updateUsersTable();

$('.btnDeleteUser').click(function (e) {
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
            // Make an AJAX request using the userID to the backend and delete the user.
            $.post('./php/deleteUser.php', { userID: userID }, function (response) {
                if (response == 'true') {
                    // Reload the page
                    Swal.fire({
                        title: "User Deleted!",
                        text: "The user has been deleted.",
                        icon: "success",
                        heightAuto: false
                    }).then(() => {
                        updateUsersTable();
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

let editUserID = 0;

$('.btnEditUser').click(function (e) {
    e.preventDefault();

    let userID = $(this).attr('userID');

    // Gets the user data from the backend
    $.post('./php/fetchUserEditData.php', { userID: userID }, function (res) {
        let user = JSON.parse(res);

        $('#txtEditFirstName').val(user.firstName);
        $('#txtEditLastName').val(user.lastName);

        editUserID = userID;
       
        $('#modalEditUser').modal('show');
    });
});

$('#formEditUser').submit(function (e) {
    e.preventDefault();

    let firstName = $('#txtEditFirstName').val();
    let lastName = $('#txtEditLastName').val();

    // Sets the data to be sent to the backend
    $.post('./php/updateUserEditData.php',
        {
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
                    // You need to change this to make it async!!
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