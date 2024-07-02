<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Card Styles */
        
        .card {
            --bg: #e8e8e8;
            --contrast: #e2e0e0;
            --grey: #93a1a1;
            position: relative;
            padding: 9px;
            background-color: var(--bg);
            border-radius: 35px;
            box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px, rgba(10, 37, 64, 0.35) 0px -2px 6px 0px inset;
            margin: auto;
            max-width: 1100px; /* Adjust max-width as needed */
            text-align: center;
            color: black;
            font-family: monospace;
        }

        .card-overlay {
            position: absolute;
            inset: 0;
            pointer-events: none;
            background: repeating-conic-gradient(var(--bg) 0.0000001%, var(--grey) 0.000104%) 60% 60%/600% 600%;
            filter: opacity(10%) contrast(105%);
            border-radius: inherit;
        }

        .card-inner {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            background-color: var(--contrast);
            border-radius: 30px;
            padding: 20px;
        }

        /* Additional Styles */
        .group {
            display: flex;
            line-height: 28px;
            align-items: center;
            position: relative;
            max-width: 190px;
            margin-bottom: 10px;
        }

        .input {
            width: 100%;
            height: 40px;
            line-height: 28px;
            padding: 0 1rem;
            padding-left: 2.5rem;
            border: 2px solid transparent;
            border-radius: 8px;
            outline: none;
            background-color: #f3f3f4;
            color: #0d0c22;
            transition: .3s ease;
        }

        .input::placeholder {
            color: #9e9ea7;
        }

        .input:focus, .input:hover {
            outline: none;
            border-color: rgba(234,76,137,0.4);
            background-color: #fff;
            box-shadow: 0 0 0 4px rgba(234, 76, 137, 0.1);
        }

        .icon {
            position: absolute;
            left: 1rem;
            fill: #9e9ea7;
            width: 1rem;
            height: 1rem;
        }

        .highlight {
            background-color: orange; /* Adjust as needed */
        }
/* Button Styles */
.btn-secondary {
        background-color: orange;
        border-color: orange;
    }

    .btn-secondary:hover, .btn-secondary:focus {
        background-color: #ff8c00; /* Darker shade of orange on hover/focus */
        border-color: #ff8c00;
    }

    .btn-primary {
        background-color: orange;
        border-color: orange;
    }

    .btn-primary:hover, .btn-primary:focus {
        background-color: #ff8c00; /* Darker shade of orange on hover/focus */
        border-color: #ff8c00;
    }
        body {
            background-color: #800000;
            padding-top: 20px;
        }
    </style>
</head>
<body>
<div class="card">
    <div class="card-overlay"></div>
    <div class="card-inner">
        <h1>Student List</h1>
        <div class="group">
            <svg class="icon" aria-hidden="true" viewBox="0 0 24 24"><g><path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path></g></svg>
            <input id="searchInput" placeholder="Search" type="search" class="input">
        </div>

        <a class="btn btn-secondary mb-3" href="home.php">Back</a>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#studentModal">Add Student</button>

        <!-- Table to display student list -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>School ID</th>
                    <th>Last Name</th>
                    <th>First Name</th>
                    <th id="sortableYearLevel" class="sortable">Year Level <span class="sort-icon">▲</span></th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="studentTableBody">
                <!-- Data will be inserted here by jQuery -->
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="studentModalLabel">Add Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="studentForm">
                    <input type="hidden" id="editMode" name="editMode" value="0">
                    <input type="hidden" id="editStudentId" name="editStudentId">
                    <div class="mb-3">
                        <label for="student_id" class="form-label">Student ID</label>
                        <input type="text" class="form-control" id="student_id" name="student_id" required>
                    </div>
                    <div class="mb-3">
                        <label for="student_lastname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="student_lastname" name="student_lastname" required>
                    </div>
                    <div class="mb-3">
                        <label for="student_firstname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="student_firstname" name="student_firstname" required>
                    </div>
                    <div class="mb-3">
                        <label for="student_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="student_email" name="student_email" required>
                    </div>
                    <div class="mb-3">
                        <label for="student_yearlevel" class="form-label">Year Level</label>
                        <select class="form-control" id="student_yearlevel" name="student_yearlevel" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Student</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    var sortOrder = 'ASC';

    // Initial fetch of students
    fetchStudents(sortOrder);

    // Function to filter and highlight rows based on search input
    $('#searchInput').on('input', function() {
        var searchText = $(this).val().trim().toLowerCase();
        if (searchText === '') {
            // If search input is empty, show all rows
            $('#studentTableBody tr').removeClass('d-none').removeClass('highlight');
        } else {
            // Filter rows based on search input
            $('#studentTableBody tr').each(function() {
                var rowText = $(this).text().toLowerCase();
                if (rowText.includes(searchText)) {
                    $(this).removeClass('d-none').addClass('highlight');
                } else {
                    $(this).addClass('d-none').removeClass('highlight');
                }
            });
        }
    });

    // Function to fetch students from server
    function fetchStudents(sortOrder) {
        $.ajax({
            url: 'fetch_students.php',
            method: 'GET',
            data: { sortOrder: sortOrder },
            success: function(data) {
                $('#studentTableBody').html(data);
            }
        });
    }

    // Sorting by year level functionality (existing code)
    $('#sortableYearLevel').on('click', function() {
        sortOrder = (sortOrder === 'ASC') ? 'DESC' : 'ASC';
        fetchStudents(sortOrder);
        $('.sort-icon').text(sortOrder === 'ASC' ? '▲' : '▼');
    });

    // Modal form submission (existing code)
    $('#studentForm').on('submit', function(e) {
        e.preventDefault();
        var url = $('#editMode').val() == 1 ? 'update_student.php' : 'save_student.php';
        $.ajax({
            type: 'POST',
            url: url,
            data: $(this).serialize(),
            success: function(response) {
                $('#studentModal').modal('hide');
                fetchStudents(sortOrder);
                $('#studentForm')[0].reset();
                $('#editMode').val(0);
            }
        });
    });

    // Edit student button click (existing code)
    $(document).on('click', '.editBtn', function() {
        var student_id = $(this).data('id');
        $.ajax({
            url: 'get_student.php',
            method: 'GET',
            data: { student_id: student_id },
            success: function(data) {
                var student = JSON.parse(data);
                $('#editMode').val(1);
                $('#editStudentId').val(student.student_id);
                $('#student_id').val(student.student_id);
                $('#student_lastname').val(student.student_lastname);
                $('#student_firstname').val(student.student_firstname);
                $('#student_yearlevel').val(student.student_yearlevel);
                $('#student_email').val(student.student_email);
                $('#studentModal').modal('show');
            }
        });
    });

    // Delete student button click (existing code)
    $(document).on('click', '.deleteBtn', function() {
        var student_id = $(this).data('id');
        if (confirm('Are you sure you want to delete this student?')) {
            $.ajax({
                url: 'delete_student.php',
                method: 'POST',
                data: { student_id: student_id },
                success: function(response) {
                    fetchStudents(sortOrder);
                }
            });
        }
    });

});
</script>

</body>
</html>
