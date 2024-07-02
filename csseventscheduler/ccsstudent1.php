<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('images/ccsstudent1bg.png');
            background-size: cover;
            background-position: center;
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center">Add New Student</h2>
        <form id="ccsstudent1" method="POST" action="add_student.php">

            <div class="form-group">
                <label for="student_name">Student Name</label>
                <input type="text" class="form-control" id="student_name" name="student_name" required>
            </div>
            <div class="form-group">
                <label for="student_lastname">Student Last Name</label>
                <input type="text" class="form-control" id="student_lastname" name="student_lastname" required>
            </div>
            <div class="form-group">
                <label for="student_yearlevel">Year Level</label>
                <input type="number" class="form-control" id="student_yearlevel" name="student_yearlevel" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Add Student</button>
        </form>
        <button type="button" class="btn btn-secondary btn-block" onclick="location.href='allccsstudent.php';">Show All CCS Students</button>
        <button type="button" class="btn btn-secondary btn-block" onclick="location.href='home.php';">Back</button>
    </div>

    <script>
        document.getElementById('ccsstudent1').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form submission
            var form = this;
            var xhr = new XMLHttpRequest();
            xhr.open(form.method, form.action, true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    if (xhr.responseText.trim() === 'success') {
                        alert('New record created successfully');

                        form.reset();
                    } else {
                        alert('Error occurred while adding student');
                    }
                } else {
                    alert('Network error occurred. Please try again later.');
                }
            };
            xhr.send(new URLSearchParams(new FormData(form)));
        });
    </script>

</body>

</html>