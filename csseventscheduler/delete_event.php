<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: home.php');
    exit();
}
if (!isset($_GET['id'])) {
    header('Location: home.php');
    exit();
}
include "inclusions/dbconnection.php";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$event_id = $_GET['id'];
$sql = "DELETE FROM events WHERE id = $event_id";

if ($conn->query($sql) === TRUE) {
    echo "Event deleted successfully";
} else {
    echo "Error deleting event: " . $conn->error;
}

$conn->close();
header('Location: home.php');
exit();
?>
