<?php
include "inclusions/dbconnection.php";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : 'ASC';

$sql = "SELECT student_id, student_lastname, student_firstname, student_yearlevel FROM ccsstudent_list ORDER BY student_yearlevel $sortOrder";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['student_id']}</td>
                <td>{$row['student_lastname']}</td>
                <td>{$row['student_firstname']}</td>
                <td>{$row['student_yearlevel']}</td>
                <td>
                    <button class='btn btn-warning btn-sm editBtn' data-id='{$row['student_id']}'>Edit</button>
                    <button class='btn btn-danger btn-sm deleteBtn' data-id='{$row['student_id']}'>Delete</button>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No students found</td></tr>";
}

$conn->close();
?>
