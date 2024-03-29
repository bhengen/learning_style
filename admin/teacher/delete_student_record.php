<!DOCTYPE html>
<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../../php/db.php');

    $student_record = $_POST;
print_r($student_record);
exit;

    try {
        // Start the transaction
        mysqli_begin_transaction($conn);
      
        // sql statement to delete the record
        $query = "DELETE FROM students  WHERE student_id = ?";

        // Prepare the statement
        $stmt = mysqli_prepare($conn, $query);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "i", $student_record['student_id']);

        // Execute the statement
        mysqli_stmt_execute($stmt);
        
        // Check if the update was successful
        if (mysqli_affected_rows($conn) > 0) {
            // Commit the changes
            mysqli_commit($conn);
            echo "Delete successful. Changes committed.";
        } else {
            // Rollback if no rows were affected
            mysqli_rollback($conn);
            echo "Delete failed. Changes rolled back.";
        }
    } catch (Exception $e) {
        // Handle exceptions or errors
        echo "Error: " . $e->getMessage();
       // Rollback on error
        mysqli_rollback($conn);
    } finally {
        // Close the database connection
        mysqli_close($conn);
     }
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Delete Student Record</title>
        <link rel="stylesheet" href="../../css/admin.css">
    </head>

    <body>

        <div id="container">
                <header id="header" class="header_container">
                    <h2 id='title'>Delete Student Record </h2> 
                    <a href='../logoff.php' class='button-like-link'>Logout</a>
                </header>
            <?php include('sidebar.html'); ?>
            <div id='main_section'>
                 <h2>Removed the following Record</h2>
                <table id='record_list_table'>
                    <th class='record_list_header'>Student Id</th>
                    <th class='record_list_header'>First Name</th>
                    <th class='record_list_header'>Last Name</th>
                    <th class='record_list_header'>Role</th>
                    <th class='record_list_header'>School Name</th>
                    <th class='record_list_header'>City</th>
                    <th class='record_list_header'>State</th>
                    <th class='record_list_header'>Postal Code</th>
                    <tr id='record_row'>
                    <?php
                        echo "
                            <td class='edit_list_data'>$student_record[student_id]</td>
                            <td class='edit_list_data'>$student_record[first_name]</td>
                            <td class='edit_list_data'>$student_record[last_name]</td>
                            <td class='edit_list_data'>$student_record[class_period]</td>
                            <td class='edit_list_data'>$student_record[school_name]</td>
                            <td class='edit_list_data'>$student_record[city]</td>
                            <td class='edit_list_data'>$student_record[state]</td>
                            <td class='edit_list_data'>$student_record[postal_code]</td>
                        ";
                    ?>
                    </tr>
                </table>
        </div>
        <div id="footer"><?php include_once("../footer.php"); ?></div>
        </div>
    </body>
</html>
