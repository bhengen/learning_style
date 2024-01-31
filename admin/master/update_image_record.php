<!DOCTYPE html>
<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../../php/db.php');

    $image_record = $_POST;
    
    $query = "SELECT * FROM images where image_id='$image_record[image_id]'";
    $result = mysqli_query($conn, $query);
    $existing_record = mysqli_fetch_assoc($result);

    try {
        // Start the transaction
        mysqli_begin_transaction($conn);
      
        // Your SQL statements go here
        $query = "UPDATE images SET 
        image_name = ?,
        image_url = ?,
        question_number = ? 
        WHERE image_id = ?";

        // Prepare the statement
        $stmt = mysqli_prepare($conn, $query);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "sssi", 
            $image_record['image_name'], 
            $image_record['image_url'], 
            $image_record['question_number'],
            $image_record['image_id']);

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
        <title>Update Image Record</title>
        <link rel="stylesheet" href="../../css/admin.css">
    </head>

    <body>
        <div id="container">
                <header id="header" class="header-container">
                    <h2 id='title'>Update Image Record </h2> 
                    <a href='../logoff.php' class='button-like-link'>Logout</a>
                </header>
                <?php include('sidebar.html'); ?>
                <div id='main-section'>
                <h2>Original Record</h2>                
                <table id='record_list_table'>
                    <th class='record-list-header'>Image Name</th>
                    <th class='record-list-header'>Image Url</th>
                    <th class='record-list-header'>Question Number</th>

                    <tr id='record-row'>
                    <?php
                        echo "
                            <td class='edit-list-data'>$existing_record[image_name]</td>
                            <td class='edit-list-data'>$existing_record[image_url]</td>
                            <td class='edit-list-data'>$existing_record[question_number]</td>
                         ";
                    ?>
                    </tr>
                </table>
                <br/>
                <h2>Updated Record</h2>
                <table id='record_list_table'>
                    <th class='record-list-header'>Image Name</th>
                    <th class='record-list-header'>Image Url</th>
                    <th class='record-list-header'>Question Number</th>

                    <tr id='record_row'>
                    <?php
                        echo "
                            <td class='edit-list-data'>$image_record[image_name]</td>
                            <td class='edit-list-data'>$image_record[image_url]</td>
                            <td class='edit-list-data'>$image_record[question_number]</td>
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
