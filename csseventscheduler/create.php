<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Event</title>
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

        #createEventForm {
            background-color: #fff;
            color: #000;
            padding: 15px;
            border-radius: 5px;
            width: 80%;
        }

        .btn-custom {
            background-color: orange;
            color: #fff;
        }
    </style>
</head>

<body>
    <div id="createEventForm">
        <h2>Create Event</h2>
        <form action="save_event.php" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Event Name</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Event Name" required>
            </div>
            <div class="mb-3">
                <label for="venue" class="form-label">Event Venue</label>
                <input type="text" class="form-control" id="venue" name="venue" placeholder="Event Venue" required>
            </div>
            <div class="mb-3">
                <label for="code" class="form-label">Event Code</label>
                <input type="text" class="form-control" id="code" name="code" placeholder="Event Code" required>
            </div>
            <div class="mb-3">
                <label for="start_datetime" class="form-label">Event Start Datetime</label>
                <input type="datetime-local" class="form-control" id="start_datetime" name="start_datetime" value="<?php echo date('Y-m-d\TH:i'); ?>" required>
            </div>
            <div class="mb-3">
                <label for="end_datetime" class="form-label">Event End Datetime</label>
                <input type="datetime-local" class="form-control" id="end_datetime" name="end_datetime" value="<?php echo date('Y-m-d\TH:i'); ?>" required>
            </div>
            <button type="submit" class="btn btn-custom">Save Event</button>
            <button type="button" onclick="window.location.href='home.php'" class="btn btn-custom">Back</button>
        </form>
    </div>
</body>

</html>
