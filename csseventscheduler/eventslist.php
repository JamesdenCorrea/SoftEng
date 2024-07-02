<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event List</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<style>
        body {
            background-color: maroon;
            color: black;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
        }
        h2 {
            text-align: center;
        }
        .btn-secondary {
            background-color: orange;
            border-color: orange;
        }
        table {
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            text-align: center;
        }
    </style>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Event List</h2>
        <?php
        session_start();

        $redirectPath = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1 ? 'home.php' : 'studenthome.php';
        ?>
        <a class="btn btn-secondary mb-4" href="<?php echo $redirectPath; ?>">Back</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                   
                    <th>Title</th>
                    <th>Code</th>
                    <th>Venue</th>
                    <th>Start DateTime</th>
                    <th>End DateTime</th>
                </tr>
            </thead>
            <tbody id="eventTableBody">
                <?php
                
                include "inclusions/dbconnection.php";

             
                $conn = new mysqli($servername, $username, $password, $dbname);

                
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                
                $sql = "SELECT id, title, code, venue, start_datetime, end_datetime FROM ccs_event_history";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                       
                        echo "<td>" . $row["title"] . "</td>";
                        echo "<td>" . $row["code"] . "</td>";
                        echo "<td>" . $row["venue"] . "</td>";
                        echo "<td>" . $row["start_datetime"] . "</td>";
                        echo "<td>" . $row["end_datetime"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No events found</td></tr>";
                }

                
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
