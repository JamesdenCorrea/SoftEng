<?php
include "inclusions/dbconnection.php";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_name = $_POST['student_name'];
    $student_lastname = $_POST['student_lastname'];
    $student_yearlevel = $_POST['student_yearlevel'];
    $sql = "INSERT INTO ccsstudent_list (student_name, student_lastname, student_yearlevel) 
            VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $student_name, $student_lastname, $student_yearlevel);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
    $stmt->close();
}
$conn->close();
?>
