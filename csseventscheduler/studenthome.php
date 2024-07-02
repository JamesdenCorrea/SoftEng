<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}
$email = $_SESSION['email'];
include "inclusions/dbconnection.php";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die("Database connection error: " . $e->getMessage());
}

$sql = "SELECT id, title, venue, start_datetime FROM events ORDER BY start_datetime ASC";
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
        body {
            background-color: maroon;
            color: white;
            margin: 0;
            display: flex;
            flex-direction: column;
            font-family: Arial, sans-serif;
        }
        .container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 20px;
        }
        .calendar, .event-list {
            background-color: #fff;
            color: #000;
            padding: 15px;
            border-radius: 5px;
            width: 48%;
            box-sizing: border-box;
        }
        .event-list {
            display: flex;
            flex-direction: column;
            max-height: 500px;
            overflow-y: auto;
        }
        .event-item {
            margin-bottom: 15px;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .event-item:last-child {
            border-bottom: none;
        }
        .calendar {
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            background-color: #34626c;
            color: #fff;
            border-radius: 5px 5px 0 0;
        }
        .calendar table {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
        }
        .calendar th, .calendar td {
            padding: 15px;
            border: 1px solid #ddd;
        }
        .calendar th {
            background-color: #f4f4f4;
        }
        .calendar td:hover {
            background-color: #f0f0f0;
            cursor: pointer;
        }
        .today {
            background-color: #ffcc00;
        }
        .nav-button {
            background-color: #34626c;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }
        .hamburger {
            display: flex;
            flex-direction: column;
            cursor: pointer;
            width: 30px;
            height: 30px;
            justify-content: space-around;
            position: relative;
        }
        .hamburger div {
            width: 100%;
            height: 4px;
            background-color: #fff;
            transition: all 0.3s;
        }
        .hamburger.active div:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }
        .hamburger.active div:nth-child(2) {
            opacity: 0;
        }
        .hamburger.active div:nth-child(3) {
            transform: rotate(-45deg) translate(5px, -5px);
        }
        .menu {
            display: none;
            flex-direction: column;
            align-items: flex-start;
            background-color: #FEB941;
            position: absolute;
            top: 40px;
            left: 10px;
            border-radius: 5px;
            padding: 10px;
            z-index: 1000;
        }
        .menu.show {
            display: flex;
        }
        .menu a {
            color: maroon;
            padding: 10px;
            text-decoration: none;
            width: 100%;
        }
        .menu a:hover {
            background-color: white;
            color: maroon;
            border-radius: 5px;
        }
        .menu .active {
            color: maroon;
        }
        @media (max-width: 768px) {
            .navbar-nav {
                display: none;
            }
            .container {
                flex-direction: column;
                align-items: center;
            }
            .calendar, .event-list {
                width: 100%;
                margin-bottom: 20px;
            }
        }
        .navbar-brand {
            flex-grow: 1;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .navbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .navbar-right img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
        }
        .navbar-right span {
            color: maroon;
            font-weight: bold;
        }
        nav .container {
            justify-content: center;
            position: relative;
        }
        nav .hamburger {
            position: absolute;
            left: 10px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #FEB941; padding: 4px 0;">
        <div class="container">
            <div class="hamburger" id="hamburger">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <a class="navbar-brand" href="#">CCS Event Management System</a>
            <div class="navbar-right">
                <span><?php echo $email; ?></span>
                <img src="images/ccsadmin.png" alt="Profile Picture">
            </div>
            <div class="menu" id="menu">
            <a class="nav-link" href="eventslist.php">View Events</a>
                <a class="nav-link" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="calendar" id="calendar"></div>
        <div class="event-list" id="eventsList">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='event-item'>";
                    echo "<h3>" . $row["title"] . "</h3>";
                    echo "<p>" . $row["venue"] . "</p>";
                    echo "<p>" . date("F j, Y, g:i a", strtotime($row["start_datetime"])) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "No events found";
            }
            $conn->close();
            ?>
        </div>
    </div>
    <script>
        var currentDate = new Date();

        function createCalendar(year, month) {
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
                calendar += '<tr>';
                for (var j = 0; j < 7; j++) {
                    if (i === 0 && j < firstDayOfMonth) {
                        calendar += '<td></td>';
                    } else if (date > daysInMonth) {
                        break;
                    } else {
                        var isToday = date === currentDate.getDate() && month === currentDate.getMonth() && year === currentDate.getFullYear();
                        calendar += `<td class="${isToday ? 'today' : ''}" onclick="addEvent(${date}, ${month}, ${year})">${date}</td>`;
                        date++;
                    }
                }
                calendar += '</tr>';
            }

            calendar += '</tbody></table>';
            document.getElementById('calendar').innerHTML = calendar;
        }
        
        function previousMonth() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            createCalendar(currentDate.getFullYear(), currentDate.getMonth());
        }

        function nextMonth() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            createCalendar(currentDate.getFullYear(), currentDate.getMonth());
        }

        var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

        createCalendar(currentDate.getFullYear(), currentDate.getMonth());

        document.getElementById('hamburger').addEventListener('click', function () {
            this.classList.toggle('active');
            document.getElementById('menu').classList.toggle('show');
        });
    </script>
</body>
</html>

