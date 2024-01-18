<!DOCTYPE html>
<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../../php/db.php');


    $teacher_id = $_GET['tid'];

    $query = "SELECT * FROM teachers WHERE teacher_id=$teacher_id";
    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_assoc($result);

    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $role = $row['role'];

?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Teacher Update Form</title>
        <link rel="stylesheet" href="../../css/admin.css">
    </head>

    <body>

        <div id="container">
                <header id="header" class="header_container">
                    <h2 id='title'>Teacher Update Form </h2> 
                    <a href='../logoff.php' class='button-like-link'>Logout</a>
                </header>
            <?php include('sidebar.html'); ?>
            <div id='main_section'>
            <table id='record_list_table'>
                <th class='record_list_header'>Teacher Id</th>
                <th class='record_list_header'>First Name</th>
                <th class='record_list_header'>Last Name</th>
                <th class='record_list_header'>Role</th>
                <th class='record_list_header'>School Name</th>
                <th class='record_list_header'>City</th>
                <th class='record_list_header'>State</th>
                <th class='record_list_header'>Postal Code</td>
                <form id='editForm' action='process_teacher_record.php' method='post'>
                    <tr id='record_row'>
                <?php
                        echo "
                            <td class='edit_list_data'><input class='edit-input' type='text' value='$row[teacher_id]' name='teacher_id'></td>
                            <td class='edit_list_data'><input class='edit-input' type='text' value='$row[first_name]' name='first_name'></td>
                            <td class='edit_list_data'><input class='edit-input' type='text' value='$row[last_name]' name='last_name'></td>
                            <td class='edit_list_data'>
                                <select  id='option-select' name='role'>
                                    <option value='admin' " . ($row['role'] == 'admin' ? 'selected' : '') . ">Admin</option>
                                    <option value='teacher' " . ($row['role'] == 'teacher' ? 'selected' : '') . ">Teacher</option>
                                </select>
                            </td>
                            <td class='edit_list_data'><input class='edit-input' type='text' value='$row[school_name]' name='school_name'></td>
                            <td class='edit_list_data'><input class='edit-input' type='text' value='$row[city]' name='city'></td>
                            <td class='edit_list_data'><input class='edit-input' type='text' value='$row[state]' name='state'></td>
                            <td class='edit_list_data'><input class='edit-input' type='text' value='$row[postal_code]' name='postal_code'></td>
                            
                        ";
                ?>
                    </tr>
                    <tr>
                        <td colspan='3'><input class='edit-button' type='submit' value='update' name='command' onclick = 'return confirmAction("update");'></td>
                        <?php if( $row['role'] != 'admin' ) { ?>
                            <td colspan='3'><input class='edit-button' type='submit'  value='delete' name='command' onclick = 'return confirmAction("delete");'></td>
                        <?php } else { echo '<td></td>'; } ?>
                        <td colspan='3'><input class='edit-button' type='button'  value='reset' onclick='resetForm()'></td>
                    </tr>
                    
                </form>
        </table>
        </div>
                <div id="footer"><?php include_once("../footer.php"); ?></div>
        </div>
        <script>
            function resetForm() {
                document.getElementById('editForm').reset();
                document.getElementById('roleSelect').selectedIndex = 0; // Set the selected index to the first option
            }

            function confirmAction(action) {
                var message = '';

                if (action === 'update') {
                    message = 'Are you sure you want to update this record?';
                } else if (action === 'delete') {
                    message = 'Are you sure you want to delete this record?';
                }

                return confirm(message);
            }
        </script>
    </body>
</html>