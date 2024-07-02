<?php
session_start();

if (!isset($_POST['btnSubmit'])) {
    header('Location: studentloginform.php');
    exit();
}

if (!isset($_POST['email']) || !isset($_POST['password'])) {
    header('Location: studentloginform.php');
    exit(); 
}

include "inclusions/dbconnection.php";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    header('Location: studentloginform.php?error=connection_failed');
    exit();
}

$email = $conn->real_escape_string($_POST['email']);

$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    header('Location: studentloginform.php?error=user_not_found'); 
    exit();
}

$user = $result->fetch_assoc();
$conn->close();

$loginPassword = md5($_POST['password']);

if ($loginPassword != $user['password_hash']) {
    header('Location: studentloginform.php?error=incorrect_password');
    exit();
}

if ($user['is_admin'] == 1) {
    header('Location: studentloginform.php?error=admin_not_allowed');
    exit();
}

$_SESSION['email'] = $user['email'];
$_SESSION['student_name'] = $user['student_name'];
$_SESSION['student_last_name'] = $user['student_last_name'];
header('Location: studenthome.php');
exit();
?>
