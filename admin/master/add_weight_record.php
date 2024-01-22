<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../../php/db.php');

    $weight_record = $_POST;
    
    // set initial record exist flag to false
    $record_exists = false;

    try {
        // Start the transaction
        mysqli_begin_transaction($conn);

        // Your SQL statements go here
        $query = "INSERT INTO weights (question_number, weight) 
                VALUES (?, ?)";

        // Prepare the statement
        $stmt = mysqli_prepare($conn, $query);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ss", 
                $weight_record['question_number'], 
                $weight_record['weight']
        );

        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Check if the insert was successful
        if (mysqli_affected_rows($conn) > 0) {
            // Commit the changes
            mysqli_commit($conn);
            echo "Insert successful. Changes committed.";
        } else {
            // Rollback if no rows were affected
            mysqli_rollback($conn);
            echo "Insert failed. Changes rolled back.";
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } catch (Exception $e) {
        // Handle exceptions or errors
        $error_message = $e->getMessage();
        // Rollback on error
        mysqli_rollback($conn);
        // sef the existing record flag
        $record_exists = true;
    } finally {
        // Close the database connection
        mysqli_close($conn);
    }
    
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Weight Record</title>
        <link rel="stylesheet" href="../../css/admin.css">
    </head>

    <body>
        <div id="container">
            <header id="header" class="header_container">
                <h2 id='title'>Add Weight Record </h2> 
                <a href='../logoff.php' class='button-like-link'>Logout</a>
            </header>
            <?php include('sidebar.html'); ?>
            <div id='main_section'>
            <?php 
                if ($record_exists) {
                    echo "<h4>There was an error adding the record to the database: $error_message</h4>";
                } else {
                    echo "<h4>The following teacher has been added to the database:</h4>"; 
                    echo "
                        <table id='record_list_table'>
                            <th class='record_list_header'>Question Number</th>
                            <th class='record_list_header'>Weight</th>
                            <tr id='record_row'>
                                <td class='add_list_data'>$weight_record[question_number]</td>
                                <td class='add_list_data'>$weight_record[weight]</td>
                            </tr>
                        </table>
                    ";
                }
            ?>
        </div>
        <div id="footer"><?php include_once("../footer.php"); ?></div>
    </body>
</html>