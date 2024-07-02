<?php
include "inclusions/dbconnection.php";

$conn = new mysqli($servername, $username, $password, $dbName);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnSubmit'])) {
    $student_id = $conn->real_escape_string($_POST['student_id']);
    $event_code = $conn->real_escape_string($_POST['event_code']);
    $attendance_time = $conn->real_escape_string($_POST['attendance']);

    // Prepare and execute the SQL query check nyo maigi
    $sql = "INSERT INTO attendance (student_id, event_code, attendance_time) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $student_id, $event_code, $attendance_time);

    if ($stmt->execute()) {
        echo "Attendance recorded successfully!";
    } else {
        echo "Error recording attendance: " . $stmt->error;
    }
    $stmt->close();
}
$conn->close();
?>
