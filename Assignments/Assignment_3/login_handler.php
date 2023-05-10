<?php session_start(); ?>
<?php require 'db_a3.php' ?>

<?php


// Retrieve username and password from form data
$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare('SELECT * FROM users WHERE username = ?');
$stmt->execute([$username]);
$user = $stmt->fetch();
if ($user) {
    if (password_verify($password, $user['password'])) {
        $_SESSION['username'] = $username;
        $_SESSION['user_id'] = $user['id'];
        header('Location:Assignment_3.php');
    } else {
        echo "Incorrect password.";
    }
} else {
    echo "Incorrect username.";
}


?>