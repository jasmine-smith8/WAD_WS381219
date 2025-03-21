$(document).ready(function () {
    // Attach a click event listener to the enrol button
    $(document).on('click', '.btnEnrolUser', function (e) {
        e.preventDefault();

        // Get the courseID from the button's attribute
        let courseID = $(this).attr('courseID');

        // Make an AJAX POST request to enrol the user
        $.post('/php/user/enrolNewUser.php', { 
            userID: sessionStorage.getItem('userID'), // Assuming userID is stored in sessionStorage
            courseID: courseID 
        }, function (response) {
            if (response === 'true') {
                Swal.fire({
                    title: "Enrolled Successfully!",
                    text: "You have been enrolled in the course.",
                    icon: "success",
                    heightAuto: false
                });
            } else {
                Swal.fire({
                    title: "Enrolment Failed!",
                    text: response,
                    icon: "error",
                    heightAuto: false
                });
            }
        }).fail(function () {
            Swal.fire({
                title: "Error!",
                text: "An error occurred while processing your request.",
                icon: "error",
                heightAuto: false
            });
        });
    });
});