$(document).ready(function () {
    // Load the navbar and footer
        $("#user-navbar").load("/pages/components/user-navbar.html");
        $("#user-footer").load("/pages/components/user-footer.html");

    // Attach a click event listener to the enroll button
    $(document).on('click', '.btnEnrollUser', function (e) {
        e.preventDefault();

        // Get the courseID from the button's attribute
        let courseID = $(this).attr('courseID');

        // Make an AJAX POST request to enroll the user
        $.post('/php/user/enrollNewUser.php', { 
            userID: sessionStorage.getItem('userID'),
            courseID: courseID 
        }, function (response) {
            if (response === 'true') {
                Swal.fire({
                    title: "Enrolled Successfully!",
                    text: "You have been enrolled in the course.",
                    icon: "success",
                    heightAuto: false
                });
                window.location.reload();
                // sendEmailNotification(userID,courseID); // this line to send email notification, unimplemented
            } else {
                Swal.fire({
                    title: "Enrollment Failed!",
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

// Used to unenroll a user from a course
$(document).on('click', '.btnUnenrollUser', function (e) {
    e.preventDefault();
    // Get the courseID from the button's attribute
    // get the userID from the session storage
    const courseID = $(this).attr('courseID');
    const userID = sessionStorage.getItem('userID');

    if (!userID) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'User ID is not set. Please log in again.',
        });
        return;
    }

    if (courseID) {
        $.ajax({
            // Make an AJAX POST request to unenroll the user
            url: '/../../php/user/removeUserEnrollment.php',
            type: 'POST',
            data: { userID, courseID },
            success: function (response) {
                try {
                    const res = JSON.parse(response);
                    if (res.success === true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Unenrolled',
                            text: res.message,
                        }).then(() => {
                            // Reload the page
                            window.location.reload();
                        });
                    } else {
                        // Display an error message if the unenrollment fails
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: res.message,
                        });
                    }
                } catch (error) {
                    // Handle unexpected errors
                    console.error('Error parsing response:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An unexpected error occurred.',
                    });
                }
            },
            error: function (error) {
                // Handle AJAX errors
                console.error('AJAX Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to unenroll from the course. Please try again later.',
                });
            },
        });
    } else {
        // Display an error message if the courseID is missing
        console.error('Course ID is missing.');
    }
});

// unimplemented function to send email notification
// function sendEmailNotification(userID, courseID) {
//     $.ajax({
//         url: '/php/user/sendEmailNotification.php',
//         type: 'POST',
//         data: { userID, courseID },
//         success: function (response) {
//             try {
//                 const res = JSON.parse(response);
//                 if (res.success) {
//                     console.log('Email notification sent successfully:', res.message);
//                 } else {
//                     console.error('Failed to send email notification:', res.message);
//                 }
//             } catch (error) {
//                 console.error('Error parsing email notification response:', error);
//             }
//         },
//         error: function (xhr, status, error) {
//             console.error('AJAX Error while sending email notification:', error);
//         },
//     });
// }