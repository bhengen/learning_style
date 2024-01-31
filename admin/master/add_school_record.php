<!DOCTYPE html>
<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../../php/db.php');

    $school_record = $_POST;
    print_r($school_record);
    

    // set initial record exist flag to false
    $record_exists = false;

    try {
        // Check if the name already exists in the database
        $check_query = "SELECT COUNT(*) FROM schools WHERE name = ?";
        $check_stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($check_stmt, "s", $school_record['name']);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_bind_result($check_stmt, $count);
        mysqli_stmt_fetch($check_stmt);
        mysqli_stmt_close($check_stmt);

        if ($count > 0) {
            // Name already exists, handle accordingly (display an error, prevent insertion, etc.)
            echo "Error: This school already exists in the database.";
        }

        // Start the transaction
        mysqli_begin_transaction($conn);

        // Your SQL statements go here
        $query = "INSERT INTO schools (name, city, state, postal_code) 
                VALUES (?, ?, ?, ?)";

        // Prepare the statement
        $stmt = mysqli_prepare($conn, $query);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "ssss", 
            $school_record['name'], 
            $school_record['city'], 
            $school_record['state'], 
            $school_record['postal_code']);

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
        echo "Error: " . $e->getMessage();
        // Rollback on error
        mysqli_rollback($conn);
        // set the existing record flag
        $record_exists = true;
        echo $record_exists;
    } finally {
        // Close the database connection
        mysqli_close($conn);
    }

?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add School Record</title>
        <link rel="stylesheet" href="../../css/admin.css">
    </head>

    <body>
        <div id="container">
            <header id="header" class="header-container">
                <h2 id='title'>Add School Record</h2> 
                <a href='../logoff.php' class='button-like-link'>Logout</a>
            </header>
            <?php include('sidebar.html'); ?>
            <div id='main-section'>
            <?php 
                if ($record_exists) {
                    echo "<h4>The following school already exists in the database:</h4>";
                } else {
                    echo "<h4>The following school has been added to the database:</h4>"; 
                }
            ?>
            <table id='record-list-table'>
                <th class='record-list-header'>Name</th>
                <th class='record-list-header'>City</th>
                <th class='record-list-header'>State</th>
                <th class='record-list-header'>Postal Code</td>
                <tr id='record_row'>
                    <td class='add-list-data'><?php echo $school_record['name']; ?></td>
                    <td class='add-list-data'><?php echo $school_record['city']; ?></td>
                    <td class='add-list-data'><?php echo $school_record['state']; ?></td>
                    <td class='add-list-data'><?php echo $school_record['postal_code']; ?></td>
                </tr>
            </table>
        </div>
        <div id="footer"><?php include_once("../footer.php"); ?></div>
    </body>
</html>