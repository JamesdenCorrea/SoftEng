<?php
include "inclusions/dbconnection.php";

session_start();

if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$event_id = $_GET['id'];

$sql = "SELECT * FROM events WHERE id = $event_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $title = $row['title'];
    $venue = $row['venue'];
    $start_datetime = $row['start_datetime'];
} else {
    header('Location: events.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_title = $_POST['title'];
    $new_venue = $_POST['venue'];
    $new_start_datetime = $_POST['start_datetime'];

    $update_sql = "UPDATE events SET title = '$new_title', venue = '$new_venue', start_datetime = '$new_start_datetime' WHERE id = $event_id";

    if ($conn->query($update_sql) === TRUE) {
        header('Location: home.php');
        exit();
    } else {
        echo "Error updating event: " . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        body {
            background-color: maroon;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        #editEventForm {
            background-color: #fff;
            color: #000;
            padding: 15px;
            border-radius: 5px;
            width: 80%;
        }

        .btn-custom {
            background-color: orange;
            color: black;
        }
    </style>
</head>

<body>
    <div id="editEventForm">
        <h2>Edit Event</h2>
        <form method="POST" onsubmit="return confirm('Are you sure you want to save changes?')">
            <div class="mb-3">
                <label for="title" class="form-label">Event Name</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $title; ?>" required>
            </div>
            <div class="mb-3">
                <label for="venue" class="form-label">Event Venue</label>
                <input type="text" class="form-control" id="venue" name="venue" value="<?php echo $venue; ?>" required>
            </div>
            <div class="mb-3">
                <label for="start_datetime" class="form-label">Event Date and Time</label>
                <input type="datetime-local" class="form-control" id="start_datetime" name="start_datetime" value="<?php echo date('Y-m-d\TH:i', strtotime($start_datetime)); ?>" required>
            </div>
            <button type="submit" class="btn btn-custom">Save Changes</button>
            <button type="button" onclick="confirmGoBack()" class="btn btn-custom">Back</button>
        </form>
    </div>

    <script>
        function confirmGoBack() {
            if (confirm('Are you sure you want to go back?')) {
                window.location.href = 'home.php';
            }
        }
    </script>
</body>

</html>