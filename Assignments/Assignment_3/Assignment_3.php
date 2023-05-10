<?php session_start(); ?>
<?php if (!isset($_SESSION['user_id'])) {
    header('Location:login.php');
} ?>
<h2>display Student Grades</h2>
<form method="get" action="displayStudentGrades.php">
    <label for="student_id">Enter Student ID:</label>
    <input type="text" name="student_id" id="student_id">
    <br><br>
    <input type="submit" value="Submit">
</form>
<?php if ($_SESSION['user_id'] == 1) { ?>
    <h2>add new Student with grades</h2>
    <form method="get" <?php if ($_GET['num_courses'] >= 1)
        echo 'action="addnewStudentwithgrades.php"' ?>>
            <label>Name:</label>
            <input type="text" name="name" value=<?php echo $_GET['name'] ?>><br>

        <label>Major:</label>
        <input type="text" name="major" value="<?php echo $_GET['major'] ?>"><br>

        <label>UniversityID</label>
        <input type="text" name="universityID" value="<?php echo $_GET['universityID'] ?>"><br>

        <label>Number of courses:</label>
        <input type="number" name="num_courses" value="<?php echo $_GET['num_courses'] ?>"><br>
        <?php
        if ($_GET['num_courses'] >= 1) {
            for ($i = 1; $i <= $_GET['num_courses']; $i++) {
                ?>
                <label>Course Code:</label>
                <input type="text" name="course_code[]"><br>
                <label>Credit:</label>
                <input type="number" name="credit[]"><br>
                <label>Grade:</label>
                <input type="text" name="grade[]"><br>
                <?php
            }
        } ?>

        <input type="submit" value="Submit">
    </form>
<?php } ?>
<h1>Upload Student Pictures</h1>
<form action="UploadStudentPictures.php" method="post" enctype="multipart/form-data">
    <label for="sid">Student ID:</label>
    <input type="text" name="sid" id="sid"><br><br>
    <label for="pic">Select picture(s) to upload:</label>
    <input type="file" name="pic[]" id="pic" multiple><br><br>
    <input type="submit" name="submit" value="Upload">
</form>