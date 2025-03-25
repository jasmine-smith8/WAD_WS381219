
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
            $('#editCourseDesc').val(course.courseDesc);
    
            editCourseID = courseID;
           
            $('#modalEditCourse').modal('show');
        });
    });
    
    $('#formEditCourse').submit(function (e) {
        e.preventDefault();
    
        let courseTitle = $('#editCourseTitle').val();
        let courseDesc = $('#editCourseDesc').val();
    
        // Sets the data to be sent to the backend
        $.post('/../../php/course/updateCourseEditData.php',
            {
                courseID: editCourseID,
                courseTitle: courseTitle,
                courseDesc: courseDesc 
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
    // Make an AJAX POST request to fetch enrolled users
    $.post('/../../php/user/fetchEnrolledUsers.php', {courseID: courseID}, 
        function (response) {
        try {
            const users = JSON.parse(response);

            // Build the HTML content for the enrolled users
            let content = '<ul>';
            users.forEach(user => {
                content += `<li>${user.firstName} (${user.email})</li>`;
            });
            content += '</ul>';

            // Insert the content into the modal
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

// Close modal logic
$('#closeModalViewUsers, #closeModalFooterViewUsers').on('click', function () {
    $('#modalViewUsers').modal('hide');
});


function htmlentities(str) {
    return $('<div/>').text(str).html();
}

