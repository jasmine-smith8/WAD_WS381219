// Used to fetch and display the user's course history - unimplemented
// function updateCourseHistory() {
//     $.ajax({
//         url: '/../../php/course/fetchCourseHistory.php',
//         method: 'GET',
//         dataType: 'json',
//         success: function(courses) {
//             let tableBody = $('#coursesTable tbody');
//             tableBody.empty(); // Clear existing table content

//             courses.forEach(course => {
//                 let row = `
//                     <tr>
//                         <td>${htmlentities(course.courseID)}</td>
//                         <td>${htmlentities(course.courseTitle)}</td>
//                         <td>${htmlentities(course.courseDate)}</td>
//                     </tr>
//                 `;
//                 tableBody.append(row);
//             });
//                 },
//                 error: function(xhr, status, error) {
//                     console.error('Error fetching course history:', error);
//                 }
//             });
// }


$(document).ready(function() {
    $("#user-navbar").load("/pages/components/user-navbar.html");
    $("#user-footer").load("/pages/components/user-footer.html");
});