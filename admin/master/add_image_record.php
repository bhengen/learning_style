<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../../php/db.php');

    $image_record = $_POST;
    $question_number = $image_record['question_number'].$image_record['question_option'];
    $image_url = 'images/' . $image_record['image_url'];
    
    // set initial record exist flag to false
    $record_exists = false;

    try {
        // Check if the name already exists in the database
        $check_query = "SELECT COUNT(*) FROM images WHERE question_number = ?";
        $check_stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($check_stmt, "s", $question_number);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_bind_result($check_stmt, $count);
        mysqli_stmt_fetch($check_stmt);
        mysqli_stmt_close($check_stmt);

        if ($count > 0) {
            // Question Number already exists, handle accordingly (display an error, prevent insertion, etc.)
            echo "Error: This Question Number already exists in the database.";
            exit;
        }

        // Start the transaction
        mysqli_begin_transaction($conn);

        // Your SQL statements go here
        $query = "INSERT INTO images (image_name, image_url, question_number) 
                VALUES (?, ?, ?)";

        // Prepare the statement
        $stmt = mysqli_prepare($conn, $query);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "sss", 
            $image_record['image_name'],
            $image_url, 
            $question_number);

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
        <title>Add Image Record</title>
        <link rel="stylesheet" href="../../css/admin.css">
    </head>

    <body>
        <div id="container">
            <header id="header" class="header_container">
                <h2 id='title'>Add Image Record</h2> 
                <a href='../logoff.php' class='button-like-link'>Logout</a>
            </header>
            <?php include('sidebar.html'); ?>
            <div id='main_section'>
            <?php 
                if ($record_exists) {
                    echo "<h4>The following image already exists in the database:</h4>";
                } else {
                    echo "<h4>The following image has been added to the database:</h4>"; 
                }
            ?>
            <table id='record_list_table'>
                <th class='record_list_header'>Image Name</th>
                <th class='record_list_header'>Image Url</th>
                <th class='record_list_header'>Question Number</th>
                <tr id='record_row'>
                    <td class='add_list_data'><?php echo $image_record['image_name']; ?></td>
                    <td class='add_list_data'><?php echo $image_url; ?></td>
                    <td class='add_list_data'><?php echo $question_number; ?></td>

                </tr>
            </table>
        </div>
        <div id="footer"><?php include_once("../footer.php"); ?></div>
    </body>
</html>