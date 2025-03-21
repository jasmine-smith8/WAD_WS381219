function updateCoursesTable() {
    $.ajax({
        url: 'php/course/fetchCourseEditData.php',
        method: 'GET',
        dataType: 'json',
        success: function(courses) {
            let tableBody = $('#coursesTable tbody');
            tableBody.empty(); // Clear existing table content

            courses.forEach(course => {
                let row = `
                    <tr>
                        <th scope="row"><img class="rounded-circle"
                            src="/img/fire.png"
                            alt="Icon for User" width="50" height="50"></th>
                        <td>${htmlentities(course.courseTitle)}</td>
                        <td>${htmlentities(course.courseDescription)}</td>
                        <td>${htmlentities(course.courseDate)}</td>
                        <td>${htmlentities(course.courseDuration)}</td>
                        <td>${htmlentities(course.maxAttendees)}</td>
                        <td>
                            <div class="btn-group">
                                <a href="#" courseID="${course.courseID}" class="btn btn-primary btnDeleteCourse">Delete Course</a>
                                <a href="#" courseID="${course.courseID}" class="btn btn-primary btnEditCourse">Edit Course</a>
                            </div>
                        </td>
                    </tr>
                `;
                tableBody.append(row);
            });

            // Reinitialize DataTable
            new DataTable('#coursesTable');
        },
        error: function(xhr, status, error) {
            console.error('Error fetching courses:', error);
        }
    });
}

$(document).ready(function() {
    updateCoursesTable();

    $(document).on('click','.btnDeleteCourse',function(e) {
        e.preventDefault();
    
        let courseID = $(this).attr('courseID');
    
        Swal.fire({
            title: "Are you sure you want to delete this user?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete them!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Make an AJAX request using the userID to the backend and delete the user.
                $.post('php/course/deleteCourse.php', { courseID: courseID }, function (response) {
                    if (response == 'true') {
                        // Reload the page
                        Swal.fire({
                            title: "User Deleted!",
                            text: "The user has been deleted.",
                            icon: "success",
                            heightAuto: false
                        }).then(() => {
                            updateCoursesTable();
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
    
    $(document).on('click','.btnEditCourse',function(e) {
        e.preventDefault();
    
        let courseID = $(this).attr('courseID');
    
        // Gets the user data from the backend
        $.post('php/course/fetchCourseEditData.php', { userID: userID }, function (res) {
            let user = JSON.parse(res);
    
            $('#txtEditFirstName').val(user.firstName);
            $('#txtEditLastName').val(user.lastName);
    
            editCourseID = courseID;
           
            $('#modalEditCourse').modal('show');
        });
    });
    
    $('#formEditUser').submit(function (e) {
        e.preventDefault();
    
        let firstName = $('#txtEditFirstName').val();
        let lastName = $('#txtEditLastName').val();
    
        // Sets the data to be sent to the backend
        $.post('php/course/updateCourseEditData.php',
            {
                courseID: editCourseID,
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
});

function htmlentities(str) {
    return $('<div/>').text(str).html();
}

