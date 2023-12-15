<?PHP
// program to update the student record
// called from display_student_data.php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../php/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Retrieve form data using $_POST
        $studentId = $_POST["student_id"];
        $firstName = $_POST["first_name"];
        $lastName = $_POST["last_name"];
        $classPeriod = $_POST["class_period"];
        $submitAction = strtolower($_POST["submit_action"]);

        // Check if the submit action is valid
        if ($submitAction !== "update" && $submitAction !== "delete" && $submitAction !== "add") {
            throw new Exception("Invalid submit action");
        }

        // Check if class_period is within the valid range
        if ($submitAction === "update" && (!is_numeric($classPeriod) || $classPeriod < 1 || $classPeriod > 6)) {
            throw new Exception("Class Period must be a number between 1 and 6");
        }

        // Construct the query based on the submit action
        if ($submitAction === "update" && isset($_POST["submit_action"])) {
            // Update logic
            $query = "UPDATE students SET first_name = '$firstName', last_name = '$lastName', class_period = '$classPeriod' WHERE student_id = $studentId";
            $resultMessage = "Record Updated Successfully";
            $resultInfo = "Updated Student Information: Student ID - $studentId, First Name - $firstName, Last Name - $lastName, Class Period - $classPeriod";
        
        } elseif ($submitAction === "delete" && isset($_POST["submit_action"])) {
            // Delete logic
            $query = "DELETE FROM students WHERE student_id = $studentId";
            $resultMessage = "Record Removed Successfully";
            $resultInfo = "Removed Student: Student ID - $studentId";
        
        } elseif($submitAction === "add") {

            // Check for duplicate student ID
            $checkDuplicateQuery = "SELECT * FROM students WHERE student_id = $studentId";
            $duplicateResult = mysqli_query($conn, $checkDuplicateQuery);

            // record exists throw exception
            if (mysqli_num_rows($duplicateResult) > 0) {
                throw new Exception("Student ID already exists");
            }

            // Insert new student
            $query  = "INSERT INTO students VALUES ('$studentId', '$firstName', '$lastName', '$classPeriod')";
            $result = mysqli_query($conn, $query);

            // set result message
            $resultMessage = "Student Added Successfully";
            $resultInfo = "Added Student Information: Student ID - $studentId, First Name - $firstName, Last Name - $lastName, Class Period - $classPeriod";
        }

        if($submitAction != "add") {
            // Perform the query
            $result = mysqli_query($conn, $query);

            // Check for errors
            if (!$result) {
                throw new Exception(mysqli_error($conn));
            }
        }

    } catch (Exception $e) {
        // Handle exceptions
        $resultMessage = "An error occurred";
        $resultInfo = "Error Message: " . $e->getMessage();
    } finally {
        // Close the database connection
        $_SESSION['form_submitted'] = true;
        mysqli_close($conn);
    }
}

?>