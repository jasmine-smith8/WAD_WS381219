$(document).ready(function () {
    // Attach a click event listener to the enroll button
    $(document).on('click', '.btnEnrollUser', function (e) {
        e.preventDefault();

        // Get the courseID from the button's attribute
        let courseID = $(this).attr('courseID');

        // Make an AJAX POST request to enroll the user
        $.post('/php/user/enrollNewUser.php', { 
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
                sendEmailNotification(userID,courseID);
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

$(document).on('click', '.btnUnenrollUser', function (e) {
    e.preventDefault();
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
            url: '/../../php/user/removeUserEnrollment.php',
            type: 'POST',
            data: { userID, courseID },
            success: function (response) {
                try {
                    const res = JSON.parse(response);
                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Unenrolled',
                            text: res.message,
                        }).then(() => {
                            updateMyCoursesTable();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: res.message,
                        });
                    }
                } catch (error) {
                    console.error('Error parsing response:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An unexpected error occurred.',
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to unenroll from the course. Please try again later.',
                });
            },
        });
    } else {
        console.error('Course ID is missing.');
    }
});

function sendEmailNotification(userID, courseID) {
    $.ajax({
        url: '/php/user/sendEmailNotification.php',
        type: 'POST',
        data: { userID, courseID },
        success: function (response) {
            try {
                const res = JSON.parse(response);
                if (res.success) {
                    console.log('Email notification sent successfully:', res.message);
                } else {
                    console.error('Failed to send email notification:', res.message);
                }
            } catch (error) {
                console.error('Error parsing email notification response:', error);
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error while sending email notification:', error);
        },
    });
}