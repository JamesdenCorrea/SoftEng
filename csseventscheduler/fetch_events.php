<?php
include "inclusions/dbconnection.php";
$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT * FROM events ORDER BY id DESC";
$result = $conn->query($sql);

$current_datetime = date('Y-m-d H:i:s');

while ($row = $result->fetch_assoc()) {
    /*
    $row_class = ($row['end_datetime'] < $current_datetime) ? 'class="table-secondary"' : '';
    echo "<tr $row_class>
        <td>{$row['id']}</td>
        <td>{$row['title']}</td>
        <td>{$row['code']}</td>
        <td>{$row['venue']}</td>
        <td>{$row['start_datetime']}</td>
        <td>{$row['end_datetime']}</td>
        <td>
            <button class='btn btn-warning btn-sm' onclick='editEvent({$row['id']})'>Edit</button>
            <button class='btn btn-danger btn-sm' onclick='deleteEvent({$row['id']})'>Delete</button>
        </td>
    </tr>";
    */

    $row_class = ($row['end_datetime'] < $current_datetime) ? 'class="table-secondary"' : '';
    echo "<tr $row_class>
        <td>{$row['id']}</td>
        <td>{$row['title']}</td>
        <td>{$row['code']}</td>
        <td>{$row['venue']}</td>
        <td>{$row['start_datetime']}</td>
        <td>{$row['end_datetime']}</td>
    </tr>";
}
$conn->close();
?>
