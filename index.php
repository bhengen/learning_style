<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Sign In</title>
</head>
<body>
    <h2>Student Learning Assessment Tool</h2>
    <form method="post" action="assessment_page.php">
        <label for="studentId">Student ID:</label>
        <input type="text" id="studentId" name="studentId" required>

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
    <script>
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                // Page is shown from a cache (back/forward button)
                // You can perform any actions you need, such as a refresh
                window.location.reload(true); // true forces a hard refresh, ignoring cache
            }
        });
        window.addEventListener('load', function() {
            // Get references to the input fields
            var studentIdInput = document.getElementById('studentId');
            var firstNameInput = document.getElementById('firstName');
            var lastNameInput = document.getElementById('lastName');
            var classPeriodSelect = document.getElementById('classPeriod');

            // Clear the input fields
            studentIdInput.value = '';
            firstNameInput.value = '';
            lastNameInput.value = '';
            classPeriodSelect.selectedIndex = 0; // Set the default option

            // Optional: Focus on the first input field
            studentIdInput.focus();
        });
    </script>
</body>
</html>
