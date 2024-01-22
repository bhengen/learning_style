<!DOCTYPE html>
<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../../php/db.php');

    $weights_table = $_POST;
    
    $query = "SELECT * FROM weights where question_number ='$weights_table[question_number]'";
    $result = mysqli_query($conn, $query);
    $existing_record = mysqli_fetch_assoc($result);

    try {
        // Start the transaction
        mysqli_begin_transaction($conn);
      
        // Your SQL statements go here
        $query = "UPDATE weights SET 
        weight = ?
        WHERE question_number = ?";

        // Prepare the statement
        $stmt = mysqli_prepare($conn, $query);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ss",$weights_table['weight'],$weights_table['question_number']);

        // Execute the statement
        mysqli_stmt_execute($stmt);

        
        // Check if the update was successful
        if (mysqli_affected_rows($conn) > 0) {
            // Commit the changes
            mysqli_commit($conn);
            echo "Update successful. Changes committed.";
        } else {
            // Rollback if no rows were affected
            mysqli_rollback($conn);
            echo "Update failed. Changes rolled back.";
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
        <title>Update Weights Table</title>
        <link rel="stylesheet" href="../../css/admin.css">
    </head>

    <body>
        <div id="container">
                <header id="header" class="header_container">
                    <h2 id='title'>Update Weights Table</h2> 
                    <a href='../logoff.php' class='button-like-link'>Logout</a>
                </header>
                <?php include('sidebar.html'); ?>
                <div id='main_section'>
                <h2>Original Record</h2>                
                <table id='record_list_table'>
                    <th class='record_list_header'>Question Number</th>
                    <th class='record_list_header'>Weight</th>

                    <tr id='record_row'>
                    <?php
                        echo "
                            <td class='edit_list_data'>$existing_record[question_number]</td>
                            <td class='edit_list_data'>$existing_record[weight]</td>
                        ";
                    ?>
                    </tr>
                </table>
                <br/>
                <h2>Updated Record</h2>
                <table id='record_list_table'>
                    <th class='record_list_header'>Question Number</th>
                    <th class='record_list_header'>Weight</th>

                    <tr id='record_row'>
                    <?php
                        echo "
                            <td class='edit_list_data'>$student_record[question_number]</td>
                            <td class='edit_list_data'>$student_record[weight]</td>
                         ";
                    ?>
                    </tr>
                </table>
        </div>
        <div id="footer"><?php include_once("../footer.php"); ?></div>
        </div>
        <script>
            function resetForm() {
                document.getElementById('editForm').reset();
                document.getElementById('roleSelect').selectedIndex = 0; // Set the selected index to the first option
            }

        </script>
    </body>
</html>
