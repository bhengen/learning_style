<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/process_students.css" rel="stylesheet">
     <title>Processing Student Record</title>
</head>
<body>
    
<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Retrieve form data using $_POST
        $studentId = $_POST["student_id"];
        $firstName = $_POST["update_first_name"];
        $lastName = $_POST["update_last_name"];
        $classPeriod = $_POST["update_class_period"];
        $submitAction = strtolower($_POST["submit_action"]);

        // Check if the submit action is valid
        if ($submitAction !== "update" && $submitAction !== "delete") {
            throw new Exception("Invalid submit action");
        }

        // Check if class_period is within the valid range
        if ($submitAction === "update" && (!is_numeric($classPeriod) || $classPeriod < 1 || $classPeriod > 6)) {
            throw new Exception("Class Period must be a number between 1 and 6");
        }

        // Construct the query based on the submit action
        if ($submitAction === "update") {
            $query = "UPDATE students SET first_name = '$firstName', last_name = '$lastName', class_period = '$classPeriod' WHERE student_id = $studentId";
            $resultMessage = "Record Updated Successfully";
            $resultInfo = "Updated Student Information: Student ID - $studentId, First Name - $firstName, Last Name - $lastName, Class Period - $classPeriod";
        } else { // Assuming it's "delete" since we checked for valid actions
            $query = "DELETE FROM students WHERE student_id = $studentId";
            $resultMessage = "Record Removed Successfully";
            $resultInfo = "Removed Student: Student ID - $studentId";
        }

        // Perform the query
        $result = mysqli_query($conn, $query);

        // Check for errors
        if (!$result) {
            throw new Exception(mysqli_error($conn));
        }
    } catch (Exception $e) {

        if (strpos($e->getMessage(), 'Class Period must be a number between 1 and 6') !== false) {
            $resultInfo = "Error Message: The class period must be a number between 1 and 6.";
            $resultInfo .= "<br/> You entered: {$classPeriod}.";
        } else {
            $resultInfo = "Error Message: " . $e->getMessage();
        }

    } finally {
        // Close the database connection
        mysqli_close($conn);
    }
}
?>
<h2><?PHP echo"Processing Record for Student: {$firstName} {$lastName}; Action=".ucwords($submitAction)?></h2>

<div class="result-card <?php echo isset($e) ? 'error' : 'success'; ?>">
    <h2><?php echo isset($e) ? 'Error' : 'Success'; ?></h2>
    <p><?php echo $resultMessage; ?></p>
    <?php if (isset($e) || isset($resultInfo)) : ?>
        <p><?php echo isset($resultInfo) ? $resultInfo : 'An unexpected error occurred.'; ?></p>
    <?php endif; ?>
</div>

<!-- Button to go back to the student_list sheet -->
<a href="../student_list.php" class="back-button">Back to Student List</a>

</body>
</html>
