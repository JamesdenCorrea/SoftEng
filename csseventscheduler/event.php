<?php

include "inclusions/dbconnection.php";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $venue = $_POST['venue'];
    $end_datetime = $_POST['end_datetime'];
    $create_user_id = $_POST['create_user_id'];
    $update_user_id = $_POST['update_user_id'];
    $created_at = $_POST['created_at'];
    $updated_at = $_POST['updated_at'];

    $sql = "INSERT INTO events (id, title, venue, end_datetime, create_user_id, update_user_id, created_at, updated_at) VALUES (:name, :venue, :date, :start_time)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['name' => $name, 'venue' => $venue, 'date' => $date, 'start_time' => $start_time]);

    header("Location: home.php");
    exit;
}