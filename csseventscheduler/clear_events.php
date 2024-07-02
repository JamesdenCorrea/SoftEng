<?php
session_start();
include "inclusions/dbconnection.php";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "DELETE FROM events";

$response = [];
if ($conn->query($sql) === TRUE) {
    $response = ['status' => 'success', 'message' => 'All events have been deleted successfully.'];
} else {
    $response = ['status' => 'error', 'message' => 'Error deleting events: ' . $conn->error];
}
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
