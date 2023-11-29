<!DOCTYPE html>
<?php
session_start();
unset($_SESSION['timestamp']);

include('php/db.php');

$query  = "SELECT * FROM students ORDER BY student_id";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error selecting records: " . mysqli_error($conn));
}

$studentRecords = array();
while ($row = mysqli_fetch_assoc($result)) {
    $studentRecords[] = $row;
}

$existingStudents = json_encode($studentRecords);

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0">
    <link rel="stylesheet" href="css/login.css">
    <title>Sign In</title>
</head>
<body>
    <h2>Student Learning Assessment Tool</h2>
    <form method="post" action="assessment_page.php" id="signInForm">
        <label for="studentId">Student ID:</label>
        <input type="text" id="studentId" name="studentId" required>
        <span id="studentIdValidationMessage"></span>

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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
 
            // Embed existing student IDs directly into the HTML
            let existingStudents = <?php echo $existingStudents; ?>;

            // Function to validate student information
            function validateStudent() {
                event.preventDefault(); // Prevent the form from submitting
                let form = document.getElementById("signInForm");
                let studentId = form.elements["studentId"].value;
                let firstName = form.elements["firstName"].value;
                let lastName = form.elements["lastName"].value;
                let classPeriod = form.elements["classPeriod"].value;

                // Check if the entered data matches the preloaded data
                if (existingStudents.find(student => student.student_id === studentId &&
                    student.first_name.toLowerCase().trim() === firstName.toLowerCase().trim() &&
                    student.last_name.toLowerCase().trim() === lastName.toLowerCase().trim() &&
                    student.class_period === classPeriod)) {
                    // Proceed to the next page
                    form.submit();
                } else {
                    //console.log(JSON.parse(existingStudents));
                    // Display an error message or perform other actions
                    alert("Invalid student information. Please check your entries.");
                }
            }

            // Call the validateStudent function when the form is submitted
            let form = document.getElementById("signInForm");
            form.addEventListener('submit', validateStudent);
        });
    </script>
</body>
</html>
