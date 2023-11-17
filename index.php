<!DOCTYPE html>
<?php
include('db.php');
echo "hello world!";
// Now you can use $conn in this file to interact with the database
//$query = "SELECT * FROM your_table";
//$result = mysqli_query($conn, $query);
//echo $result;
// Rest of your code...
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Sign In</title>
</head>
<body>
    <h2>
        Student Learning Assessment Tool
    </h2>
    <form>

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

        <button type="submit">Sign In</button>
    </form>

</body>
</html>
