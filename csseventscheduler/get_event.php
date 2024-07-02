<?php
include "inclusions/dbconnection.php";
$conn = new mysqli($servername, $username, $password, $dbname);

$id = $_GET['id'];
$sql = "SELECT * FROM events WHERE id = $id";
$result = $conn->query($sql);

echo json_encode($result->fetch_assoc());

$conn->close();
?>
