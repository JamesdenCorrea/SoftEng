<?php
// Include the database connection file
include "inclusions/dbconnection.php";

// Create a new connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the form inputs and assign them to variables
$title = $_POST['title'];
$venue = $_POST['venue'];
$code = $_POST['code'];
$start_datetime = $_POST['start_datetime'];
$end_datetime = $_POST['end_datetime'];

session_start();
$create_user_id = $_SESSION['user_id'];
$update_user_id = $_SESSION['user_id'];

if (!isset($title) || !isset($venue) || !isset($code) || !isset($start_datetime) || !isset($end_datetime)) {
    header('Location: home.php');
    exit();
}

// Prepare an SQL statement to insert the form data into the events table
$stmt = $conn->prepare("INSERT INTO events (title, venue, code, start_datetime, end_datetime, create_user_id, update_user_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $title, $venue, $code, $start_datetime, $end_datetime, $create_user_id, $update_user_id);

// Execute the SQL statement
if ($stmt->execute()) {
    // Prepare an SQL statement to insert the same data into the ccs_event_history table
    $stmt_history = $conn->prepare("INSERT INTO ccs_event_history (title, venue, code, start_datetime, end_datetime) VALUES (?, ?, ?, ?, ?)");
    $stmt_history->bind_param("sssss", $title, $venue, $code, $start_datetime, $end_datetime);
    $stmt_history->execute();
    $stmt_history->close();
}

// Close the statement and the connection
$stmt->close();
$conn->close();

// Redirect to the home page after saving the event
header('Location: home.php');
exit();
?>
