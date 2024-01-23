<!DOCTYPE html>
<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../../php/db.php');

    $teacher_record = $_POST;

    $query = "SELECT * FROM teachers where teacher_id='$teacher_record[teacher_id]'";
    $result = mysqli_query($conn, $query);
    $existing_record = mysqli_fetch_assoc($result);

    try {
        // Start the transaction
        mysqli_begin_transaction($conn);
      
        // Your SQL statements go here
        $query = "UPDATE teachers SET 
        first_name = ?,
        last_name = ?,
        role = ?,
        school_name = ?,
        city = ?,
        state = ?,
        postal_code = ? 
        WHERE teacher_id = ?";

        // Prepare the statement
        $stmt = mysqli_prepare($conn, $query);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, "sssssssi", 
                $teacher_record['first_name'], 
                $teacher_record['last_name'], 
                $teacher_record['role'], 
                $teacher_record['school_name'], 
                $teacher_record['city'],
                $teacher_record['state'], 
                $teacher_record['postal_code'], 
                $teacher_record['teacher_id']);

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
        <title>Update Teacher Record</title>
        <link rel="stylesheet" href="../../css/admin.css">
    </head>

    <body>

        <div id="container">
                <header id="header" class="header_container">
                    <h2 id='title'>Update Teacher Record </h2> 
                    <a href='../logoff.php' class='button-like-link'>Logout</a>
                </header>
                <?php include('sidebar.html'); ?>
                <div id='main_section'>
                    <h2>Original Record</h2>                
                    <table id='record_list_table'>
                        <th class='record_list_header'>Teacher Id</th>
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
                                <td class='edit_list_data'>$existing_record[teacher_id]</td>
                                <td class='edit_list_data'>$existing_record[first_name]</td>
                                <td class='edit_list_data'>$existing_record[last_name]</td>
                                <td class='edit_list_data'>$existing_record[role]</td>
                                <td class='edit_list_data'>$existing_record[school_name]</td>
                                <td class='edit_list_data'>$existing_record[city]</td>
                                <td class='edit_list_data'>$existing_record[state]</td>
                                <td class='edit_list_data'>$existing_record[postal_code]</td>
                            ";
                        ?>
                        </tr>
                    </table>
                    <br/>
                    <h2>Updated Record</h2>
                    <table id='record_list_table'>
                        <th class='record_list_header'>Teacher Id</th>
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
                                <td class='edit_list_data'>$teacher_record[teacher_id]</td>
                                <td class='edit_list_data'>$teacher_record[first_name]</td>
                                <td class='edit_list_data'>$teacher_record[last_name]</td>
                                <td class='edit_list_data'>$teacher_record[role]</td>
                                <td class='edit_list_data'>$teacher_record[school_name]</td>
                                <td class='edit_list_data'>$teacher_record[city]</td>
                                <td class='edit_list_data'>$teacher_record[state]</td>
                                <td class='edit_list_data'>$teacher_record[postal_code]</td>
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
