<?php
include "inclusions/dbconnection.php";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("UPDATE ccsstudent_list SET student_lastname = ?, student_firstname = ?, student_yearlevel = ? WHERE student_id = ?");
$stmt->bind_param("ssis", $student_lastname, $student_firstname, $student_yearlevel, $student_id);

$student_id = $_POST['editStudentId'];
$student_lastname = $_POST['student_lastname'];
$student_firstname = $_POST['student_firstname'];
$student_yearlevel = $_POST['student_yearlevel'];

$stmt->execute();
$stmt->close();
$conn->close();

echo "Student updated successfully";
?>
