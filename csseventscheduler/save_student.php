<?php
include "inclusions/dbconnection.php";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['student_email']; // Assuming you have an email field in the form
$password_hash = md5("password"); // Hash the password before storing
$is_admin = isset($_POST['is_admin']) ? 1 : 0; // Check if admin checkbox is checked

// Insert into users table first
$stmt_user = $conn->prepare("INSERT INTO users (email, password_hash, is_admin) VALUES (?, ?, ?)");
$stmt_user->bind_param("sss", $email, $password_hash, $is_admin);

if ($stmt_user->execute()) {
  // Get the inserted user ID
  $inserted_user_id = $conn->insert_id;

  $student_id = $_POST['student_id'];
  $student_lastname = $_POST['student_lastname'];
  $student_firstname = $_POST['student_firstname'];
  $student_yearlevel = $_POST['student_yearlevel'];

  // Insert into ccsstudent_list table with the retrieved user ID
  $stmt_student = $conn->prepare("INSERT INTO ccsstudent_list (student_id, student_lastname, student_firstname, student_yearlevel, user_id) VALUES (?, ?, ?, ?, ?)");
  $stmt_student->bind_param("sssis", $student_id, $student_lastname, $student_firstname, $student_yearlevel, $inserted_user_id);

  if ($stmt_student->execute()) {
    echo "Student added successfully";
  } else {
    echo "Error adding student: " . $stmt_student->error;
  }
  $stmt_student->close();
} else {
  echo "Error adding user: " . $stmt_user->error;
}

$stmt_user->close();
$conn->close();
