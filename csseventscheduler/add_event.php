<?php
include "inclusions/dbconnection.php";
$conn = new mysqli($servername, $username, $password, $dbname);

$title = $_POST['title'];
$code = $_POST['code'];
$venue = $_POST['venue'];
$start_datetime = $_POST['start_datetime'];
$end_datetime = $_POST['end_datetime'];
$create_user_id = $_POST['create_user_id'];
$update_user_id = $_POST['update_user_id'];

$sql = "INSERT INTO events (title, code, venue, start_datetime, end_datetime, create_user_id, update_user_id) VALUES ('$title', '$code', '$venue', '$start_datetime', '$end_datetime', $create_user_id, $update_user_id)";

if ($conn->query($sql) === TRUE) {
    echo "New event created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
