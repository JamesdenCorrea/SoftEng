<?php
if (!isset($_POST['btnSubmit'])) {
    header('Location: index.php');
    exit();
}
if (!isset($_POST['email']) || !isset($_POST['password'])) {
    header('Location: index.php');
    exit();
}
include "inclusions/dbconnection.php";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    exit("Connection failed: " . $conn->connect_error);
}
$email = $conn->real_escape_string($_POST['email']);
$password = $_POST['password'];
$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    header('Location: index.php');
    exit();
}
$user = $result->fetch_assoc();
$conn->close();

$loginPassword = md5($password);
if ($loginPassword != $user['password_hash']) {
    header('Location: index.php');
    exit();
}
session_start();
$_SESSION['user_id'] = $user['id'];
$_SESSION['email'] = $user['email'];
$_SESSION['is_admin'] = $user['is_admin'];
$_SESSION['displayName'] = 'ccsadmin.png';

if ($user['is_admin'] == 1) {
    header('Location: home.php');
    exit(0);
} else {
    header('Location: studenthome.php');
    exit(0);
}
