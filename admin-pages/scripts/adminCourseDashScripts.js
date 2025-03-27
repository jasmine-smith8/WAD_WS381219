
$(document).ready(function() {
    $(document).on('click','.btnDeleteCourse',function(e) {
        e.preventDefault();
    
        let courseID = $(this).attr('courseID');
    
        Swal.fire({
            title: "Are you sure you want to delete this course?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete course!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Remove the course data from the database
                $.post('../../php/course/deleteCourse.php', { courseID: courseID }, function (response) {
                    if (response == 'true') {
                        // Reload the page
                        Swal.fire({
                            title: "Course Deleted!",
                            text: "The course has been deleted.",
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
    let editCourseID = 0;
    $(document).on('click','.btnEditCourse',function(e) {
        e.preventDefault();
    
        let courseID = $(this).attr('courseID');
    
        // Gets the user data from the backend
        $.post('/../../php/course/fetchCourseEditData.php', { courseID: courseID }, function (res) {
            let course = JSON.parse(res);
    
            $('#editCourseTitle').val(course.courseTitle);
            $('#editcourseDescription').val(course.courseDescription);
    
            editCourseID = courseID;
           
            $('#modalEditCourse').modal('show');
        });
    });
    
    $('#formEditCourse').submit(function (e) {
        e.preventDefault();
    
        let courseTitle = $('#editCourseTitle').val();
        let courseDescription = $('#editcourseDescription').val();
    
        // Sets the data to be sent to the backend
        $.post('/../../php/course/updateCourseEditData.php',
            {
                courseID: editCourseID,
                courseTitle: courseTitle,
                courseDescription: courseDescription 
            },
            function (response) {
                if (response == 'true') {
                    Swal.fire({
                        title: "Course Updated!",
                        text: "The course has been updated.",
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

$(document).on('click', '.btnViewUsers', function (e) {
    e.preventDefault();

    let courseID = $(this).attr('courseID');

    // Makes a POST request to fetch enrolled users
    $.post('/../../php/user/fetchEnrolledUsers.php', { courseID: courseID }, function (response) {
        try {
            const users = JSON.parse(response);
            //Dynamically create the header content for the modal
            let content = `
                <div class="userTitle" style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 10px; align-items: center; padding: 10px; border-bottom: 2px solid #ddd; font-weight: bold; background-color: #f9f9f9;">
                    <span>Name</span>
                    <span>Email</span>
                    <span>Action</span>
                </div>
            `;

            if (users.length > 0) {
                users.forEach(user => {
                    let firstName = user.enrolledFirstNames ? htmlentities(user.enrolledFirstNames.replace(/,/g, '')) : 'N/A';
                    let email = user.enrolledEmails ? htmlentities(user.enrolledEmails.replace(/,/g, '')) : 'N/A';
                    let userIDs = user.enrolledUserIDs ? user.enrolledUserIDs.split(',') : [];

                    // Start a row for this user
                    content += `
                        <div class="userRow" style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 10px; align-items: center; padding: 10px; border-bottom: 1px solid #ddd;">
                            <span>${firstName}</span>
                            <span>${email}</span>
                            <div>
                    `;

                    // Create a remove button for individual user IDs
                    userIDs.forEach(userID => {
                        let sanitizedUserID = htmlentities(userID.trim());

                        content += `
                            <button class="btnRemoveEnrollment" data-user-id="${sanitizedUserID}" data-course-id="${courseID}" 
                                style="background-color: #710000; color: white; border: none; padding: 8px 12px; margin-right: 5px; cursor: pointer; border-radius: 5px;">
                                Remove
                            </button>
                        `;
                    });

                    // Close the user row div
                    content += `</div></div>`;
                });
            } else {
                content += `
                    <div style="text-align: center; padding: 15px; color: #777; grid-column: span 3;">
                        No users are enrolled in this course.
                    </div>`;
            }

            // Inject HTML content into the modal
            $('#displayEnrolledUsers').html(content);

            // Show the modal
            $('#modalViewUsers').modal('show');

        } catch (error) {
            console.error('Error parsing response:', error);
            $('#displayEnrolledUsers').html('<p>Error loading attendees.</p>');
        }
    }).fail(function () {
        $('#displayEnrolledUsers').html('<p>Error fetching attendees.</p>');
    });
});



$(document).on('click', '.btnRemoveEnrollment', function (e) {
    e.preventDefault();

    let userID = $(this).attr('data-user-id');
    let courseID = $(this).attr('data-course-id');

    Swal.fire({
        title: "Are you sure you want to remove this user?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, remove user!"
    }).then((result) => {
        if (result.isConfirmed) {
            // Remove the user from the course
            $.post('/../../php/user/removeUserEnrollment.php', { userID: userID, courseID: courseID }, function (response) {
                if (response == 'true') {
                    Swal.fire({
                        title: "User Removed!",
                        text: "The user has been removed.",
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

//add ajax call to update the admin courses table
function updateCoursesTable() 
{

}
//Because there is no htmlentities function in JavaScript, we need to create one.
function htmlentities(str) {
    return $('<div/>').text(str).html();
}

