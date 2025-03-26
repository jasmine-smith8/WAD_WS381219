function updateMyCoursesTable() {
    $.ajax({
        url: '/../../php/course/fetchEnrolledCourses.php',
        method: 'GET',
        dataType: 'json',
        success: function(courses) {
            let tableBody = $('#myCoursesTable tbody');
            tableBody.empty(); // Clear existing table content

            courses.forEach(course => {
                let row = `
                    <tr>
                        <th scope="row"><img class="rounded-circle"
                            src="./img/fire.png"
                            alt="Icon for User" width="50" height="50"></th>
                        <td>${htmlentities(course.courseTitle)}</td>
                        <td>${htmlentities(course.courseDescription)}</td>
                        <td>${htmlentities(course.courseDate)}</td>
                        <td>${htmlentities(course.courseDuration)}</td>
                        <td>
                            <div class="btn-group">
                                <a href="#" courseID="${course.courseID}" class="btn btn-primary btnUnenrollUser">Unenroll</a>
                            </div>
                        </td>
                    </tr>
                `;
                tableBody.append(row);
            });

            // Reinitialize DataTable
            new DataTable('#myCoursesTable');
        },
        error: function(xhr, status, error) {
            console.error('Error fetching courses:', error);
        }
    });
}