<!DOCTYPE html>
<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../../php/db.php');

    $school_record = $_POST;
    
    $query = "SELECT * FROM schools where school_id='$school_record[school_id]'";
    $result = mysqli_query($conn, $query);
    $existing_record = mysqli_fetch_assoc($result);

    try {
        // Start the transaction
        mysqli_begin_transaction($conn);
      
        // Your SQL statements go here
        $query = "UPDATE schools SET 
        name = ?,
        city = ?,
        state = ?,
        postal_code = ? 
        WHERE school_id = ?";

        // Prepare the statement
        $stmt = mysqli_prepare($conn, $query);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ssssi", 
            $school_record['name'], 
            $school_record['city'], 
            $school_record['state'], 
            $school_record['postal_code'], 
            $school_record['school_id']);

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
        <title>Update School Record</title>
        <link rel="stylesheet" href="../../css/admin.css">
    </head>

    <body>
        <div id="container">
                <header id="header" class="header-container">
                    <h2 id='title'>Update School Record </h2> 
                    <a href='../logoff.php' class='button-like-link'>Logout</a>
                </header>
                <?php include('sidebar.html'); ?>
                <div id='main-section'>
                <h2>Original Record</h2>                
                <table id='record-list-table'>
                    <th class='record-list-header'>Name</th>
                    <th class='record-list-header'>City</th>
                    <th class='record-list-header'>State</th>
                    <th class='record-list-header'>Postal Code</th>
                    <tr id='record-row'>
                    <?php
                        echo "
                            <td class='edit-list-data'>$existing_record[name]</td>
                            <td class='edit-list-data'>$existing_record[city]</td>
                            <td class='edit-list-data'>$existing_record[state]</td>
                            <td class='edit-list-data'>$existing_record[postal_code]</td>
                        ";
                    ?>
                    </tr>
                </table>
                <br/>
                <h2>Updated Record</h2>
                <table id='record-list-table'>
                    <th class='record-list-header'>Name</th>
                    <th class='record-list-header'>City</th>
                    <th class='record-list-header'>State</th>
                    <th class='record-list-header'>Postal Code</th>
                    <tr id='record-row'>
                    <?php
                        echo "
                            <td class='edit-list-data'>$school_record[name]</td>
                            <td class='edit-list-data'>$school_record[city]</td>
                            <td class='edit-list-data'>$school_record[state]</td>
                            <td class='edit-list-data'>$school_record[postal_code]</td>
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
