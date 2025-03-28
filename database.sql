/*Database schema for the course management system*/
CREATE TABLE users (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(255) NOT NULL,
    lastName VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    userRole ENUM('admin', 'user') NOT NULL,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE courses (
    courseID INT AUTO_INCREMENT PRIMARY KEY,
    adminID INT NOT NULL,
    courseTitle VARCHAR(255) NOT NULL,
    courseDescription TEXT NOT NULL,
    courseDuration INT NOT NULL,
    courseDate DATE NOT NULL,
    maxAttendees INT NOT NULL,
    FOREIGN KEY (adminID) REFERENCES users(userID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE TABLE userCourse (
    userCourseID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT NOT NULL,
    courseID INT NOT NULL,
    UNIQUE(userID, courseID),
    FOREIGN KEY (userID) REFERENCES users(userID)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (courseID) REFERENCES courses(courseID)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);