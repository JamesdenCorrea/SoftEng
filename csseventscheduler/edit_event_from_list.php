<?php
include "inclusions/dbconnection.php";
$conn = new mysqli($servername, $username, $password, $dbname);

$id = $_POST['id'];
$title = $_POST['title'];
$code = $_POST['code'];
$venue = $_POST['venue'];
$start_datetime = $_POST['start_datetime'];
$end_datetime = $_POST['end_datetime'];
$create_user_id = $_POST['create_user_id'];
$update_user_id = $_POST['update_user_id'];

$sql = "UPDATE events SET title = '$title', code = '$code', venue = '$venue', start_datetime = '$start_datetime', end_datetime = '$end_datetime', create_user_id = $create_user_id, update_user_id = $update_user_id WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "Event updated successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
