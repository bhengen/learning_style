<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../../php/db.php');

    $student_record = $_POST;

    // set initial record exist flag to false
    $record_exists = false;

    try {
        // Start the transaction
        mysqli_begin_transaction($conn);

        // Your SQL statements go here
        $query = "INSERT INTO students (student_id, first_name, last_name, class_period, school_name, city, state, postal_code) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare the statement
        $stmt = mysqli_prepare($conn, $query);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "isssssss", 
            $student_record['student_id'],
            $student_record['first_name'], 
            $student_record['last_name'], 
            $student_record['class_period'], 
            $student_record['school_name'], 
            $student_record['city'], 
            $student_record['state'], 
            $student_record['postal_code']);

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
        <title>Add Student Formm</title>
        <link rel="stylesheet" href="../../css/admin.css">
    </head>

    <body>
        <div id="container">
            <header id="header" class="header_container">
                <h2 id='title'>Add Student Form </h2> 
                <a href='../logoff.php' class='button-like-link'>Logout</a>
            </header>
            <?php include('sidebar.html'); ?>
            <div id='main_section'>
            <?php 
                if ($record_exists) {
                    echo "<h4>The following student already exists in the database:</h4>";
                } else {
                    echo "<h4>The following student has been added to the database:</h4>"; 
                }
            ?>
            <table id='record_list_table'>
                <th class='record_list_header'>Student Id</th>
                <th class='record_list_header'>First Name</th>
                <th class='record_list_header'>Last Name</th>
                <th class='record_list_header'>Class Period</th>
                <th class='record_list_header'>School Name</th>
                <th class='record_list_header'>City</th>
                <th class='record_list_header'>State</th>
                <th class='record_list_header'>Postal Code</td>
                <tr id='record_row'>
                    <td class='add_list_data'><?php echo $student_record['student_id']; ?></td>
                    <td class='add_list_data'><?php echo $student_record['first_name']; ?></td>
                    <td class='add_list_data'><?php echo $student_record['last_name']; ?></td>
                    <td class='add_list_data'><?php echo $student_record['class_period']; ?></td>
                    <td class='add_list_data'><?php echo $student_record['school_name']; ?></td>
                    <td class='add_list_data'><?php echo $student_record['city']; ?></td>
                    <td class='add_list_data'><?php echo $student_record['state']; ?></td>
                    <td class='add_list_data'><?php echo $student_record['postal_code']; ?></td>
                </tr>
            </table>
        </div>
        <div id="footer"><?php include_once("../footer.php"); ?></div>
    </body>
</html>