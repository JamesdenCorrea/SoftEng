<?php
include "inclusions/dbconnection.php";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "DELETE FROM ccsstudent_list";

if ($conn->query($sql) === TRUE) {
    echo "All students have been deleted successfully.";
} else {
    echo "Error deleting records: " . $conn->error;
}
$conn->close();
header("Location: ccsstudent_list.php");
exit();
?>
