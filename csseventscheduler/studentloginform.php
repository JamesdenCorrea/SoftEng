<?php
session_start();
if (isset($_SESSION['email'])) {
    header('Location: studenthome.php');
    exit();
}

include "inclusions/dbconnection.php";

$error = '';

if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'user_not_found':
            $error = "No user found with that email.";
            break;
        case 'incorrect_password':
            $error = "Invalid credentials.";
            break;
        case 'admin_not_allowed':
            $error = "Only students can log in.";
            break;
        case 'connection_failed':
            $error = "Database connection failed.";
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Student Login</title>
  <link href="css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: url('images/background.jpg') no-repeat center center fixed;
      background-size: cover;
      display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  margin: 0; /* Remove default margin */
    }
    .container {
      max-width: 400px;
      margin: auto;
      padding: 40px 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
      font-size: 24px;
      margin-bottom: 20px;
      text-align: center;
    }

    .form-floating {
      margin-bottom: 20px;
    }

    .form-floating label {
      color: #6c757d;
    }

    .form-floating input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ced4da;
      border-radius: 4px;
      box-sizing: border-box;
    }

    .btn-primary, .btn-secondary {
      width: 100%;
      padding: 10px;
      border-radius: 4px;
      cursor: pointer;
      color: #fff;
      background-color: orange;
      border-color:orange;
    }

    .btn-primary:hover, .btn-secondary:hover {
      background-color: #004c4c;
      border-color: #004c4c;
    }

    .logo {
      width: 300px;
      height: auto;
      margin-bottom: 20px;
    }

    .error {
      color: red;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <form method="POST" action="studentlogin.php">
      <div class="text-center mb-4">
        <img src="images/UPHSDALTA.png" alt="Student logo" class="logo">
      </div>
      <h1 class="h3 mb-3 fw-normal">Student Login</h1>
      
      <?php if ($error) { echo "<p class='error'>$error</p>"; } ?>

      <div class="form-floating">
        <input type="email" class="form-control" id="student_id" placeholder="Student ID" name="email" required>
        <label for="student_id">Email</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
        <label for="password">Password</label>
      </div>
      <button class="btn btn-primary" type="submit" name="btnSubmit">Login</button>
      <a href="index.php" class="btn btn-secondary mt-3">Back</a>
    </form>
  </div>
</body>
</html>
