<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}
$email = $_SESSION['email'];
$displayName = $_SESSION['displayName'] ?? 'ccsadmin';
include "inclusions/dbconnection.php";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die("Database connection error: " . $e->getMessage());
}

$sql = "SELECT id, title, code, venue, start_datetime, end_datetime FROM events ORDER BY start_datetime DESC";
$result = $conn->query($sql);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CCS Event Scheduler</title>
    <link href="css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <style>
        body, html {
            background-color: #fff;
            color: #333;
            margin: 0;
            width: 100%;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background-color: #800000;
            padding: 0px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            width: 100%;
        }
        .navbar-brand {
            margin-left: 20px;
            color: #fff;
        }
        .navbar-logo {
            height: 100px; /* Adjust this value as needed */
            margin-right: 10px; /* Optional: add some space between the image and the text */
            vertical-align: middle; /* Align the image vertically in the middle */
        }
        .navbar-right {
            margin-right: 20px;
            display: flex;
            justify-content: flex-end;
        }
        .navbar-right span {
            color: #fff;
            margin-right: 10px;
        }
        .navbar-right img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
        }
        .container {
            display: flex;
            margin: 20px;
            max-width: 100%; /* Set a maximum width for the container */
            margin: 0 auto; /* Center the container horizontally */
            padding: 0;
        }
        .sidebar {
            width: 220px;
            background-color: #d9d9d9;
            border-radius: ;
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sidebar a {
            color: #333;
            padding: 8px;
            text-decoration: none;
            font-weight: ;
            display: block; /* Ensure each link occupies full width */
            margin-bottom: 15px; /* Add space between links */
        }
        .sidebar a:hover {
            background-color: #cccccc;
            border-radius: 8px;
        }
        .content {
            flex-grow: 1;
            margin-left: 20px;
            width: 100%;
        }
        .dashboard {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
        }
        .dashboard h2 {
            margin: 0;
        }
        .calendar {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            max-width: 800px; /* adjust the max-width to your desired value */
            margin: 20px auto;
        }
        .calendar-title {
            text-align: center;
        }
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }
        .calendar-header h2 {
            margin: 0;
        }
        .calendar table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .calendar th, .calendar td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
            cursor: pointer;
        }
        .calendar th {
            background-color: #f9f9f9;
        }
        .calendar td:hover {
            background-color: #f0f0f0;
        }
        .today {
            background-color: #ffcc00;
        }
        .event-list {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            max-height: 300px;
            overflow-y: auto; 
            margin: 0 auto;
            text-align: center;
            overflow-x: auto;
            white-space: nowrap;
            text-align: center;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .event-item {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            display: inline-block;
            margin: 10px;
            flex: 0 0 45%;
        }
        .event-item:last-child {
            border-bottom: none;
        }
        .edit-button, .delete-button {
            padding: 5px 10px;
            border-radius: 4px;
            color: #fff;
            text-decoration: none;
            margin-right: 5px;
        }
        .edit-button {
            background-color: #800000;
        }
        .delete-button {
            background-color: #800000;
        }
        .clear-events-button {
            background-color: #800000;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
        }
        .nav-button {
            background-color: #f0f2f5;
            color: #333;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin: 0 5px;
        }
        .nav-button:hover {
            background-color: #ddd;
        }
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                margin-bottom: 20px;
            }
            .content {
                margin-left: 0;
            }
        }
        .Btn {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        width: 45px;
        height: 45px;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition-duration: .3s;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.199);
        background-color: rgb(255, 65, 65);
    }

    /* plus sign */
    .sign {
        width: 100%;
        transition-duration: .3s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .sign svg {
        width: 17px;
    }

    .sign svg path {
        fill: white;
    }

    /* text */
    .text {
        position: absolute;
        right: 0%;
        width: 0%;
        opacity: 0;
        color: white;
        font-size: 1.2em;
        font-weight: 600;
        transition-duration: .3s;
    }

    /* hover effect on button width */
    .Btn:hover {
        width: 125px;
        border-radius: 40px;
        transition-duration: .3s;
    }

    .Btn:hover .sign {
        width: 30%;
        transition-duration: .3s;
        padding-left: 20px;
    }

    /* hover effect button's text */
    .Btn:hover .text {
        opacity: 1;
        width: 70%;
        transition-duration: .3s;
        padding-right: 10px;
    }

    /* button click effect*/
    .Btn:active {
        transform: translate(2px ,2px);
    }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="images/UPHSD.png" alt="Logo" class="navbar-logo"> CCS Event Management System</a>
            <div class="navbar-right">
                <span><?php echo $email; ?></span>
                <img src="images/admin.png" alt="Profile Picture">
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="sidebar">
            <div>
                
                <a href="create.php">Create Event</a>
                <a href="allccsstudent.php">CCS Student List</a>
                <a href="attendance.php">Attendance</a>
                <a href="attendancelist.php">Attendance List</a>
                <a href="eventslist.php">Events List</a>
                </div>
    <button class="Btn" onclick="logout()">
        <div class="sign"><svg viewBox="0 0 512 512"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path></svg></div>
        <div class="text">Logout</div>
    </button>
        </div>
        <div class="content">
            <div class="dashboard">
                <h2>Dashboard</h2>
            </div>
            <div class="calendar" id="calendar"></div>
            <div class="event-list" id="eventsList">
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<div class='event-item'>";
                        echo "<h3>" . $row["title"] . "</h3>";
                        echo "<p>" . $row["code"] . "</p>";
                        echo "<p>" . $row["venue"] . "</p>";
                        echo "<p>" . date("F j, Y, g:i a", strtotime($row["start_datetime"])) . "</p>";
                        echo "<p>" . date("F j, Y, g:i a", strtotime($row["end_datetime"])) . "</p>";
                        echo "<a href='edit_event.php?id=" . $row["id"] . "' class='edit-button'>Edit</a>&nbsp;";
                        echo "<a href='delete_event.php?id=" . $row["id"] . "' class='delete-button'>Delete</a>";
                        echo "</div>";
                    }
                } else {
                    echo "No events found";
                }
                ?>
            </div>
            <button class="clear-events-button" id="clearEventsButton">Clear All Events</button>
        </div>
    </div>
    <script>
        console.log("Script is running");

        var currentDate = new Date();
        var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

        function createCalendar(year, month) {
            console.log("Creating calendar for", monthNames[month], year);
            var firstDayOfMonth = new Date(year, month, 1).getDay();
            var daysInMonth = new Date(year, month + 1, 0).getDate();
            var calendar = `
                <div class="calendar-header">
                    <button class="nav-button" onclick="previousMonth()">&lt; Previous</button>
                    <h2>${monthNames[month]} ${year}</h2>
                    <button class="nav-button" onclick="nextMonth()">Next &gt;</button>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Sun</th>
                            <th>Mon</th>
                            <th>Tue</th>
                            <th>Wed</th>
                            <th>Thu</th>
                            <th>Fri</th>
                            <th>Sat</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            var date = 1;
            for (var i = 0; i < 6; i++) {
                calendar += "<tr>";
                for (var j = 0; j < 7; j++) {
                    if (i === 0 && j < firstDayOfMonth) {
                        calendar += "<td></td>";
                    } else if (date > daysInMonth) {
                        break;
                    } else {
                        var todayClass = date === currentDate.getDate() && month === currentDate.getMonth() && year === currentDate.getFullYear() ? "today" : "";
                        calendar += `<td class="${todayClass}">${date}</td>`;
                        date++;
                    }
                }
                calendar += "</tr>";
            }
            calendar += `
                    </tbody>
                </table>
            `;
            document.getElementById("calendar").innerHTML = calendar;
        }

        function previousMonth() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            createCalendar(currentDate.getFullYear(), currentDate.getMonth());
        }

        function nextMonth() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            createCalendar(currentDate.getFullYear(), currentDate.getMonth());
        }

        document.getElementById('clearEventsButton').addEventListener('click', function () {
            if (confirm("Are you sure you want to clear all events?")) {
                window.location.href = 'clear_events.php';
            }
        });

        document.addEventListener('DOMContentLoaded', function () {
            createCalendar(currentDate.getFullYear(), currentDate.getMonth());
        });
        function logout() {
        if (confirm("Are you sure you want to logout?")) {
            window.location.href = 'logout.php'; // Adjust the logout URL as per your application
        }
    }
    </script>
</body>
</html>
