<?php

// Database connection settings
$host = "localhost";
$username = "root";
$password = "root";

// Connect to MySQL server using PDO
try {
    $conn = new PDO("mysql:host=$host", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS StudentsDB";
try {
    $conn->exec($sql);
} catch (PDOException $e) {
    echo "Error creating database: " . $e->getMessage() . "\n";
}

// Connect to StudentsDB database
$dbname = "StudentsDB";
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
}

// Create Students table
$sql = "CREATE TABLE IF NOT EXISTS Students (
    Sid int(11) PRIMARY KEY AUTO_INCREMENT,
    UniversityID varchar(8) UNIQUE,
    Name varchar(50),
    Major varchar(50)
)";
try {
    $conn->exec($sql);
} catch (PDOException $e) {
    echo "Error creating Students table: " . $e->getMessage() . "\n";
}

// Create Grades table
$sql = "CREATE TABLE IF NOT EXISTS Grades (
    Gid int(11) PRIMARY KEY AUTO_INCREMENT,
    Sid int(11),
    FOREIGN KEY (Sid) REFERENCES Students(Sid),
    CourseCode varchar(10),
    Credits int(11),
    CourseGrade varchar(4)
)";
try {
    $conn->exec($sql);
} catch (PDOException $e) {
    echo "Error creating Grades table: " . $e->getMessage() . "\n";
}

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)";
try {
    $conn->exec($sql);
} catch (PDOException $e) {
    echo "Error creating users table: " . $e->getMessage() . "\n";
}
// Create studentPictures table
$sql = "CREATE TABLE IF NOT EXISTS studentPictures (
    id int(11) PRIMARY KEY AUTO_INCREMENT,
    Sid int(11),
    FOREIGN KEY (Sid) REFERENCES Students(Sid),
    PicFilename varchar(100)
)";
try {
    $conn->exec($sql);
    // echo "studentPictures table created successfully\n";
} catch (PDOException $e) {
    echo "Error creating studentPictures table: " . $e->getMessage() . "\n";
}

// Insert data into Students table
$sql = "INSERT IGNORE INTO Students (UniversityID, Name, Major) VALUES 
    ('12345678', 'John Smith', 'Computer Science'),
    ('87654321', 'Jane Doe', 'Electrical Engineering')";
try {
    $conn->exec($sql);
} catch (PDOException $e) {
    echo "Error inserting data into Students table: " . $e->getMessage() . "\n";
}

// Insert data into users table
$sql = "INSERT IGNORE INTO users (id,username, password) VALUES 
    ('1', 'Mohammed', '" . password_hash('12345', PASSWORD_DEFAULT) . "'),
    ('2', 'Ahmed', '" . password_hash('123123', PASSWORD_DEFAULT) . "'),
    ('3', 'Ali', '" . password_hash('123456', PASSWORD_DEFAULT) . "')";

try {
    $conn->exec($sql);
} catch (PDOException $e) {
    echo "Error inserting data into users table: " . $e->getMessage() . "\n";
}

// Insert data into Grades table
$sql = "INSERT IGNORE INTO Grades (Gid ,Sid, CourseCode, Credits, CourseGrade) VALUES 
    (1,1, 'COMP101', 3, 'A'),
    (2,1, 'MATH101', 4, 'B'),
    (3,2, 'EE101', 3, 'C'),
    (4,2, 'MATH101', 4, 'F')";

try {
    $conn->exec($sql);
} catch (PDOException $e) {
    echo "Error inserting data into Grades table: " . $e->getMessage() . "\n";
}

?>