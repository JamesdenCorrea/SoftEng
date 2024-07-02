<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #800000; /* Maroon background color for the body */
            color: black; /* Text color for better contrast */
            padding-top: 50px; /* Space for the fixed navbar */
            margin: 0; /* Reset default margin */
        }

        .content-wrapper {
            background-color: #fff; /* White background color for the main content */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: -50px; /* Compensate for padding-top on body */
            position: relative; /* Ensure relative positioning */
            z-index: 1; /* Ensure content is above body background */
        }

        .form-container {
            background-color: #f9f9f9; /* Light gray background color for the form container */
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            text-align: center; /* Center content within the form-container */
            position: relative; /* Ensure relative positioning */
            z-index: 2; /* Ensure form is above content-wrapper */
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-title {
            margin-bottom: 1.5rem;
        }

        .table-container {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        /* Adjust button width to 50% */
        .btn-half-width {
            width: 50%;
        }

        /* Center buttons */
        .center-buttons {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            margin-top: 10px; /* Added margin for spacing */
        }

        /* Adjust input width */
        #eventCodeInput {
            width: 50%; /* Reducing input width by 50% */
            margin-right: 10px; /* Adding right margin for spacing */
        }

        /* Center the input */
        .center-input {
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2 class="form-title">Attendance List</h2>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
                <div class="form-group center-input"> <!-- Added center-input class here -->
                    
                    <input type="text" id="eventCodeInput" name="event_code" class="form-control" placeholder="Event Code">
                </div>
                <div class="center-buttons">
                    <button type="submit" class="btn btn-warning btn-block btn-half-width">Submit</button>
                </div>
            </form>

            <?php
            session_start();

            $redirectPath = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1 ? 'home.php' : 'studenthome.php';
            ?>
            <div class="center-buttons">
                <a class="btn btn-warning btn-block btn-half-width mt-3" href="<?php echo $redirectPath; ?>">Back</a>
            </div>
        </div>

        <?php
        if (isset($_GET['event_code'])) {
            $eventCode = $_GET['event_code'];

            include "inclusions/dbconnection.php";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM attendance WHERE event_code = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("s", $eventCode);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo '<div class="table-container">';
                    echo '<h3 class="mt-4">Attendance Records for Event Code: ' . htmlspecialchars($eventCode) . '</h3>';
                    echo '<table class="table table-bordered">';
                    echo '<thead><tr><th>ID</th><th>Student ID</th><th>Event Code</th><th>Attendance Time</th></tr></thead>';
                    echo '<tbody>';
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['student_id'] . "</td>";
                        echo "<td>" . $row['event_code'] . "</td>";
                        echo "<td>" . $row['attendance_time'] . "</td>";
                        echo "</tr>";
                    }
                    echo '</tbody></table>';
                    echo '</div>';
                } else {
                    echo "<p class='mt-4'>No attendance records found for event code $eventCode.</p>";
                }

                $stmt->close();
            } else {
                echo "<p class='mt-4'>Failed to prepare statement: " . $conn->error . "</p>";
            }

            $conn->close();
        }
        ?>
    </div>
</body>
</html>
