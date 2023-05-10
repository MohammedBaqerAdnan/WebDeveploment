<?php
require 'db_a3.php'
    ?>

<?php
// // Get student ID from HTTP GET method
// $student_id = isset($_GET['student_id']) ? $_GET['student_id'] : null;
// if (!$student_id) {
//     echo "<p>Please enter a valid Student ID.</p>";
//     exit();
// }

// // Retrieve student's name and major from Students table
// // $student_query = $db->prepare("SELECT Name, Major FROM students WHERE Sid = ?");
// // $student_query->execute([$student_id]);
// // $student_result = $student_query->fetch(PDO::FETCH_ASSOC);
// // $student_name = $student_result['Name'];
// // $student_major = $student_result['Major'];
// // echo $student_name;
// // echo $student_major;

// $student_query = $db->prepare("SELECT Name, Major FROM students WHERE UniversityID = ?");
// $student_query->execute([$student_id]);
// $student_result = $student_query->fetch(PDO::FETCH_ASSOC);
// print_r($student_result);
// if ($student_result !== false) {
//     $student_name = $student_result['Name'];
//     $student_major = $student_result['Major'];
//     echo $student_name;
//     echo $student_major;
//     echo "Student ID: $student_id";
// } else {
//     echo "No matching record found in Students table.";
// }

// // Retrieve course codes, credits, and grades from Grades table for the student
// $grades_query = $db->prepare("SELECT CourseCode, Credits, CourseGrade FROM Grades WHERE UniversityID = ?");
// $grades_query->execute([$student_id]);
// $grades_result = $grades_query->fetchAll(PDO::FETCH_ASSOC);

// // Calculate cumulative GPA, total credits passed, and total credits registered
// $total_credits_passed = 0;
// $total_credits_registered = 0;
// $total_grade_points = 0;
// foreach ($grades_result as $grade) {
//     $credits = $grade['Credits'];
//     $course_grade = $grade['CourseGrade'];
//     $total_credits_registered += $credits;
//     if ($course_grade != 'F') {
//         $total_credits_passed += $credits;
//         $grade_points = 4.0 - (ord($course_grade) - ord('A')) * 0.33;
//         $total_grade_points += $grade_points * $credits;
//     }
// }

// $cumulative_gpa = $total_grade_points / $total_credits_passed;

// // Display student's name and major
// echo "<h2>Student Information</h2>";
// echo "<p>Name: $student_name</p>";
// echo "<p>Major: $student_major</p>";

// // Display grades in an HTML table
// echo "<h2>Grades</h2>";
// echo "<table border='1'>";
// echo "<tr><th>Course Code</th><th>Credits</th><th>Grade</th></tr>";
// foreach ($grades_result as $grade) {
//     $course_code = $grade['CourseCode'];
//     $credits = $grade['Credits'];
//     $course_grade = $grade['CourseGrade'];
//     if ($course_grade == 'F') {
//         echo "<tr style='background-color: red;'>";
//     } else {
//         echo "<tr>";
//     }
//     echo "<td>$course_code</td><td>$credits</td><td>$course_grade</td></tr>";
// }
// echo "</table>";

// // Display cumulative GPA, total credits passed, and total credits registered
// echo "<h2>Cumulative GPA</h2>";
// echo "<p>GPA: $cumulative_gpa</p>";
// echo "<p>Total Credits Passed: $total_credits_passed</p>";
// echo "<p>Total Credits Registered: $total_credits_registered</p>";



?>

<?php
// Connect to database using PDO
// $host = "localhost";
// $username = "root";
// $password = "root";
// $dbname = "StudentsDB";
// // Connect to MySQL server using PDO
// $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
// $db = new PDO('mysql:host=localhost;dbname=mydb;charset=utf8', 'username', 'password');

// Get student ID from HTTP GET request
// $student_id = $_GET['student_id'];

// Get student ID from HTTP GET method
$student_id = isset($_GET['student_id']) ? $_GET['student_id'] : null;
if (!$student_id) {
    echo "<p>Please enter a valid Student ID.</p>";
    exit();
}

// Get student's name and major
$student_query = $conn->prepare("SELECT Name, Major FROM students WHERE Sid = ?");
$student_query->execute([$student_id]);
$student_result = $student_query->fetch(PDO::FETCH_ASSOC);
if ($student_result !== false) {
    $student_name = $student_result['Name'];
    $student_major = $student_result['Major'];
} else {
    echo "No matching record found in Students table.";
    exit();
}
// Get student's grades for all courses
$grades_query = $conn->prepare("SELECT CourseCode, Credits, CourseGrade FROM Grades WHERE Sid = ?");
$grades_query->execute([$student_id]);
$grades_results = $grades_query->fetchAll(PDO::FETCH_ASSOC);

// Calculate total credits registered and total credits passed
$total_credits_registered = 0;
$total_credits_passed = 0;
foreach ($grades_results as $grade_result) {
    $total_credits_registered += $grade_result['Credits'];
    if ($grade_result['CourseGrade'] != 'F') {
        $total_credits_passed += $grade_result['Credits'];
    }
}

// Calculate cumulative GPA
$cumulative_gpa = 0;
$credits_attempted = 0;
foreach ($grades_results as $grade_result) {
    $grade_points = 0;
    switch ($grade_result['CourseGrade']) {
        case 'A':
            $grade_points = 4;
            break;
        case 'A-':
            $grade_points = 3.67;
            break;
        case 'B+':
            $grade_points = 3.33;
            break;
        case 'B':
            $grade_points = 3;
            break;
        case 'B-':
            $grade_points = 2.67;
            break;
        case 'C+':
            $grade_points = 2.33;
            break;
        case 'C':
            $grade_points = 2;
            break;
        case 'C-':
            $grade_points = 1.67;
            break;
        case 'D+':
            $grade_points = 1.33;
            break;
        case 'D':
            $grade_points = 1;
            break;
        default:
            $grade_points = 0;
            break;
    }
    $credits_attempted += $grade_result['Credits'];
    $cumulative_gpa += $grade_points * $grade_result['Credits'];
}
if ($credits_attempted != 0) {
    $cumulative_gpa /= $credits_attempted;
}

// Print student's name, major, and grades in an HTML table
echo "<h2>Student Information</h2>";
echo "<p>Name: $student_name</p>";
echo "<p>Major: $student_major</p>";
echo "<table>";
echo "<tr><th>Course Code</th><th>Credits</th><th>Grade</th></tr>";
foreach ($grades_results as $grade_result) {
    $course_code = $grade_result['CourseCode'];
    $credits = $grade_result['Credits'];
    $grade = $grade_result['CourseGrade'];
    $color = ($grade == 'F') ? 'red' : 'black';
    echo "<tr style=\"color: $color\"><td>$course_code</td><td>$credits</td><td>$grade</td></tr>";
}
echo "<tr><td><b>Cumulative GPA:</b></td><td>$cumulative_gpa</td><td></td></tr>";
echo "<tr><td><b>Total Credits Passed:</b></td><td>$total_credits_passed</td><td></td></tr>";
echo "<tr><td><b>Total Credits Registered:</b></td><td>$total_credits_registered</td><td></td></tr>";
echo "</table>";




?>