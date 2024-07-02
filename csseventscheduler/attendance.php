<?php
include "inclusions/dbconnection.php";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';

// Function to check if student exists in ccsstudent_list
function isStudentExists($conn, $student_id) {
    $sql = "SELECT student_id FROM ccsstudent_list WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $stmt->store_result();
    $count = $stmt->num_rows;
    $stmt->close();
    return $count > 0;
}

// Function to check if event code exists in events table
function isEventCodeValid($conn, $event_code) {
    $sql = "SELECT code FROM events WHERE code = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $event_code);
    $stmt->execute();
    $stmt->store_result();
    $count = $stmt->num_rows;
    $stmt->close();
    return $count > 0;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['btnSubmit'])) {
    $student_id = $conn->real_escape_string($_POST['student_id']);
    $event_code = $conn->real_escape_string($_POST['event_code']);
    $attendance_time = date("Y-m-d H:i:s"); // Capture the current time in PHP

    // Check if student exists
    if (isStudentExists($conn, $student_id)) {
        // Check if event code is valid
        if (isEventCodeValid($conn, $event_code)) {
            // Insert attendance
            $sql = "INSERT INTO attendance (student_id, event_code, attendance_time) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $student_id, $event_code, $attendance_time);

            if ($stmt->execute()) {
                $message = "Attendance recorded successfully!";
            } else {
                $message = "Error recording attendance: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $message = "Invalid event code. Attendance not recorded.";
        }
    } else {
        $message = "Invalid student ID. Attendance not recorded.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Attendance Form</title>
  <link href="css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <style>
    body {
      background-color: #800000;
      font-family: Arial, sans-serif;
      background-image: url('studentbg.png'); /* Add background image */
      background-size: cover;
      margin: 0;
      padding: 0;
      height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
    }
    .container {
      max-width: 400px;
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
    .btn-primary {
      background-color: maroon;
      border-color: maroon;
      width: 100%;
      padding: 10px;
      border-radius: 4px;
      cursor: pointer;
      margin-top: 10px; /* Added margin to match the back button */
    }
    .btn-primary:hover {
      background-color: #800000; /* Darken maroon color on hover */
      border-color: #800000;
    }
    .btn-secondary {
      background-color: #ffc107;
      border-color: #ffc107;
      width: 100%;
      padding: 10px;
      border-radius: 4px;
      cursor: pointer;
      margin-top: 10px; /* Added margin to match the submit button */
    }
    .btn-secondary:hover {
      background-color: #cca300; /* Darken dark yellow color on hover */
      border-color: #cca300;
    }

    .message {
      text-align: center;
      margin-bottom: 20px;
      color: green;
    }
    .error-message {
      text-align: center;
      margin-bottom: 20px;
      color: red;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1 class="h3 mb-3 fw-normal">Attendance</h1>
    <?php if ($message): ?>
        <p class="<?php echo strpos($message, 'Error') === false ? 'message' : 'error-message'; ?>"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form method="POST" action="">
      <div class="form-floating">
        <input type="text" class="form-control" id="student_id" placeholder="Student ID" name="student_id" required>
        <label for="student_id">Student ID</label>
      </div>
      <div class="form-floating">
        <input type="text" class="form-control" id="event_code" placeholder="Event Code" name="event_code" required>
        <label for="event_code">Event Code</label>
      </div>
      <div class="form-floating">
        <input type="text" class="form-control" id="attendance" name="attendance" value="<?php echo date("Y-m-d h:i:s A"); ?>" readonly>
        <label for="attendance">Attendance Time</label>
      </div>
      <button class="btn btn-primary" type="submit" name="btnSubmit">Submit Attendance</button>
      <a href="home.php" class="btn btn-secondary mt-3">Back</a>
    </form>
  </div>
  <script>
    function updateTime() {
      var now = new Date();
      var hours = now.getHours();
      var minutes = now.getMinutes();
      var seconds = now.getSeconds();
      var ampm = hours >= 12 ? 'PM' : 'AM';
      hours = hours % 12;
      hours = hours ? hours : 12; 
      minutes = minutes < 10 ? '0' + minutes : minutes;
      seconds = seconds < 10 ? '0' + seconds : seconds;
      var timeString = hours + ':' + minutes + ':' + seconds + ' ' + ampm;
      document.getElementById('attendance').value = timeString;
    }
    updateTime();
    setInterval(updateTime, 1000);
  </script>
</body>
</html>
