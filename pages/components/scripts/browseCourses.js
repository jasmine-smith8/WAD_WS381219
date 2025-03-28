$(document).ready(function () {
    // updateCoursesTable(); // unimplemented
    $("#coursesTable").DataTable();

    // Load the navbar and footer components
    $("#user-navbar").load("/pages/components/user-navbar.html");
    $("#user-footer").load("/pages/components/user-footer.html");

    // Store the user ID in the session storage
    const userID = "<?php echo isset($_SESSION['userID']) ? $_SESSION['userID'] : ''; ?>";
    if (userID) {
        sessionStorage.setItem('userID', userID);
    } else {
        console.error('User ID is not set in the session.');
    }
    // Handle "View Course" button click
    $(document).on('click', '.btnViewCourse', function (e) {
        e.preventDefault();
        const courseID = $(this).attr('courseID');
        if (courseID) {
            window.location.href = `/pages/viewCourse.php?courseID=${courseID}`;
        } else {
            console.error('Course ID is missing.');
        }
    });

    // Handle "enroll" button click
    $(document).on('click', '.btnEnrollUser', function (e) {
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
                // Make an AJAX POST request to enroll the user
                url: '/../../php/enrollUser.php',
                type: 'POST',
                data: { userID, courseID },
                success: function (response) {
                    try {
                        const res = JSON.parse(response);
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'enrolled',
                                text: res.message,
                            }).then(() => {
                                // Reload the page
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                // Display an error message if the enrollment fails
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
                error: function (xhr, status, error) {
                    // Handle AJAX errors
                    console.error('AJAX Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to enroll in the course. Please try again later.',
                    });
                },
            });
        } else {
            // Display an error message if the courseID is missing
            console.error('Course ID is missing.');
        }
    });
});

// function updateCoursesTable() {
//     $.ajax({
//         url: '/../../php/course/fetchCourses.php',
//         method: 'GET',
//         dataType: 'json',
//         success: function(courses) {
//             let tableBody = $('#coursesTable tbody');
//             tableBody.empty(); // Clear existing table content

//             courses.forEach(course => {
//                 let row = `
//                     <tr>
//                         <th scope="row"><img class="rounded-circle"
//                             src="./img/fire.png"
//                             alt="Icon for User" width="50" height="50"></th>
//                         <td>${htmlentities(course.courseTitle)}</td>
//                         <td>${htmlentities(course.courseDescription)}</td>
//                         <td>${htmlentities(course.courseDate)}</td>
//                         <td>${htmlentities(course.courseDuration)}</td>
//                         <td>${htmlentities(course.enrolledUsers)}</td>
//                         <td>${htmlentities(course.maxAttendees)}</td>
//                         <td>
//                             <div class="btn-group">
//                                 <a href="#" courseID="${course.courseID}" class="btn btn-primary btnViewCourse">View Course</a>
//                                 <a href="#" courseID="${course.courseID}" class="btn btn-primary btnenrollUser">enroll</a>
//                             </div>
//                         </td>
//                     </tr>
//                 `;
//                 tableBody.append(row);
//             });

//             // Reinitialize DataTable
//             new DataTable('#coursesTable');
//         },
//         error: function(xhr, status, error) {
//             console.error('Error fetching courses:', error);
//         }
//     });
// }

// Escape HTML entities in a string to prevent XSS attacks
function htmlentities(str) {
    if (typeof str !== 'string') {
        return str; // Return as-is if not a string
    }
    let div = document.createElement('div');
    div.innerText = str;
    return div.innerHTML;
}