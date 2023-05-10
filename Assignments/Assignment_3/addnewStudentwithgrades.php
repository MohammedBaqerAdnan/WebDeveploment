<?php require 'db_a3.php' ?>

<?php
// Define regular expressions for input validation
$name_pattern = "/^[A-Za-z]+(\s[A-Za-z]+)*$/";
$major_pattern = "/^[A-Za-z]+(\s[A-Za-z]+)*$/";
$code_pattern = "/^[a-zA-Z]{4,5}[\d]{3}$/";
$credits_pattern = "/^[1-4]$/";
$grade_pattern = "/^(A|A\-|B\+|B|B\-|C\+|C|C\-|D\+|D|F)$/";
$ID_pattern = "/^[\d]{8,9}$/";

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    // Get student details from form
    $name = $_GET['name'];
    $major = $_GET['major'];
    $number_courses = $_GET['num_courses'];
    $ID = $_GET['universityID'];



    // Validate student details
    if (!preg_match($name_pattern, $name)) {
        echo "<p>Invalid name.</p>";
        exit();
    }
    if (!preg_match($major_pattern, $major)) {
        echo "<p>Invalid major.</p>";
        exit();
    }
    if (!$num_courses <= 0) {
        echo "Invalid number of courses. Please enter a positive integer.";
        exit();
    }
    if (!preg_match($ID_pattern, $ID)) {
        echo "<p>Invalid ID.</p>";
        exit();
    }
    print_r($_GET['course_code']);
    echo "<br>";
    print_r($_GET['credit']);
    echo "<br>";
    print_r($_GET['grade']);

    // Start transaction
    $conn->beginTransaction();

    try {
        // Insert student details into Students table
        $insert_student_query = $conn->prepare("INSERT IGNORE INTO `students`(`UniversityID`, `Name`, `Major`) VALUES (?,?,?)");
        $insert_student_query->execute([$ID, $name, $major]);
        $student_id = $conn->lastInsertId();
        $insert_grade_query = $conn->prepare("INSERT INTO Grades (Sid, CourseCode, Credits, CourseGrade) VALUES (?, ?, ?, ?)");
        //insert grades into Grades table
        for ($i = 0; $i < $number_courses; $i++) {
            $course_code = $_GET['course_code'][$i];
            $credits = $_GET['credit'][$i];
            $grade = $_GET['grade'][$i];
            if (!preg_match($code_pattern, $course_code)) {
                echo "<p>Invalid course code.</p>";
                exit();
            }
            if (!preg_match($credits_pattern, $credits)) {
                echo "<p>Invalid number of credits.</p>";
                exit();
            }
            if (!preg_match($grade_pattern, $grade)) {
                echo "<p>Invalid grade.</p>";
                exit();
            }
            $insert_grade_query->execute([$student_id, $course_code, $credits, $grade]);
        }
        // Commit transaction
        $conn->commit();
        echo "New student and grades added successfully!";



    } catch (PDOException $e) {
        // Rollback transaction
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }




}
?>