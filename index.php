<!DOCTYPE html>
<?php
session_start();
unset($_SESSION['timestamp']);

// This is the main landing page

include('php/db.php');

$query  = "SELECT * FROM students ORDER BY student_id";
$result = mysqli_query($conn, $query);

// Check for query execution errors
if (!$result) {
    die("Error selecting records: " . mysqli_error($conn));
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Sign In</title>

</head>
<body>
    <h2>Student Learning Assessment Tool</h2>
    <form method="post" action="assessment_page.php">
        <label for="studentId">Student ID:</label>
        <?php
            echo "<select id='studentId' name='studentId'>";
            echo "<option value='' disabled selected>Select Student ID</option>"; // Default option
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='{$row['student_id']}'>{$row['student_id']}</option>";
            }
            echo "</select>";
        ?>

        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName" required>

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName" required>

        <select id="classPeriod" name="classPeriod" required>
            <option value="1">Period 1</option>
            <option value="2">Period 2</option>
            <option value="3">Period 3</option>
            <option value="4">Period 4</option>
            <option value="5">Period 5</option>
            <option value="6">Period 6</option>
        </select>

        <button type="submit" id="submitButton" target="">Sign In</button>
    </form>
    <?php
        // Close the database connection
        mysqli_close($conn);
    ?>
<script>
    // Attach a handler to the onpageshow event
    window.addEventListener('pageshow', function (event) {
        // Check if the event's persisted property is false
        // This indicates that the page is being loaded from the cache or the back-forward cache
        if (event.persisted) {
            // Force a page refresh
            location.reload();
        }
    });

    $(document).ready(function() {
        
        // Clear input values on page load
        $('#studentId').val('');
        $('#firstName').val('');
        $('#lastName').val('');
        $('#classPeriod').val('');
        
        // Handle the change event for studentId
        $('#studentId').change(function() {
            var studentId = $(this).val();

            if (studentId !== '') {
                // Make your AJAX call here...
                $.ajax({
                    url: 'php/get_student_data.php',
                    type: 'POST',
                    data: { studentId: studentId },
                    dataType: 'json', // Ensure that jQuery interprets the response as JSON
                    success: function(studentData) {
                        console.log('Parsed data:', studentData);
                        // Verify that IDs match keys and log values
                        // Set field values
                        $('#firstName').val(studentData[0].first_name);
                        $('#lastName').val(studentData[0].last_name);
                        $('#classPeriod').val(studentData[0].class_period);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', status, error);
                    }
                });
            }
        });
    });
</script>

</body>
</html>
