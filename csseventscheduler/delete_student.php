<?php
include "inclusions/dbconnection.php";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student_id = $_POST['student_id'];

$stmt = $conn->prepare("DELETE FROM ccsstudent_list WHERE student_id = ?");
$stmt->bind_param("s", $student_id);
$stmt->execute();
$stmt->close();
$conn->close();

echo "Student deleted successfully";
?>
