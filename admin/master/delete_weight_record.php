<!DOCTYPE html>
<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../../php/db.php');

    $weight_record = $_POST;

    $query = "SELECT * FROM weights where weight_id='$weight_record[weight_id]'";
    $result = mysqli_query($conn, $query);
    $new_record = mysqli_fetch_assoc($result);

    try {
        // Start the transaction
        mysqli_begin_transaction($conn);
      
        // sql statement to delete the record
        $query = "DELETE FROM weights WHERE weight_id = ?";

        // Prepare the statement
        $stmt = mysqli_prepare($conn, $query);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "i", $weight_record['weight_id']);

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
        <title>Delete Weight Record</title>
        <link rel="stylesheet" href="../../css/admin.css">
    </head>

    <body>

        <div id="container">
                <header id="header" class="header_container">
                    <h2 id='title'>Delete Weight Record </h2> 
                    <a href='../logoff.php' class='button-like-link'>Logout</a>
                </header>
            <?php include('sidebar.html'); ?>
            <div id='main_section'>
                 <h2>Removed the following Record</h2>
                <table id='record_list_table'>
                    <th class='record_list_header'>Question Number</th>
                    <th class='record_list_header'>Weight</th>
                    <tr id='record_row'>
                    <?php
                        echo "
                            <td class='edit_list_data'>$weight_record[question_number]</td>
                            <td class='edit_list_data'>$weight_record[weight]</td>
                        ";
                    ?>
                    </tr>
                </table>
        </div>
        <div id="footer"><?php include_once("../footer.php"); ?></div>
        </div>
    </body>
</html>
