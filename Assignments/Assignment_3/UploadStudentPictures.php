<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
session_start();
require_once 'db_a3.php';

// Function to generate unique filename
function generateUniqueFilename($filename)
{
    $path = "uploads/"; // directory where uploaded files will be stored
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $basename = basename($filename, ".$ext");
    $i = 1;
    while (file_exists($path . $basename . '_' . $i . '.' . $ext)) {
        $i++;
    }
    return $basename . '_' . $i . '.' . $ext;
}
// Handle file upload when form is submitted
if (isset($_POST['submit'])) {
    // Get student ID from session
    $_SESSION['Sid'] = $_POST['sid'];
    $Sid = $_SESSION['Sid'];
    // Loop through all uploaded files and store filename in database
    foreach ($_FILES['pic']['tmp_name'] as $key => $tmp_name) {
        $filename = $_FILES['pic']['name'][$key];
        $filetype = $_FILES['pic']['type'][$key];
        $filesize = $_FILES['pic']['size'][$key];
        $tmpname = $_FILES['pic']['tmp_name'][$key];
        // Generate unique filename
        $newfilename = generateUniqueFilename($filename);
        if (!file_exists('uploads')) {
            mkdir('uploads', 0777, true);
        }
        // Move uploaded file to directory
        move_uploaded_file($tmpname, "uploads/" . $newfilename);
        // Insert filename into database
        $sql = "INSERT INTO studentPictures (Sid, PicFilename) VALUES (:Sid, :PicFilename)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':Sid', $Sid);
        $stmt->bindParam(':PicFilename', $newfilename);
        $stmt->execute();
    }
}

echo '<!DOCTYPE html><html lang="en"><head>    <meta charset="UTF-8">    <meta name="viewport" content="width=device-width, initial-scale=1.0"></head><body>';




// Get all pictures for the logged-in student
if (isset($_SESSION['Sid'])) {
    $Sid = $_SESSION['Sid'];
    $sql = "SELECT PicFilename FROM studentPictures WHERE Sid = :Sid";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':Sid', $Sid);
    $stmt->execute();
    $pictures = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<?php if (isset($pictures) && !empty($pictures)): ?>
    <h2>Uploaded Pictures</h2>
    <div>
        <?php foreach ($pictures as $picture): ?>
            <img src="uploads/<?php echo htmlspecialchars($picture['PicFilename']); ?>" alt="Student Picture"
                style="max-width: 200px; max-height: 200px; margin: 10px;">
        <?php endforeach; ?>
    </div>
<?php endif; ?>
</body>

</html>