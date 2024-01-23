<!DOCTYPE html>
<?php

    // error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../../php/db.php');

    $school_id = $_GET['school_id'];

    $query = "SELECT * FROM schools where school_id='$school_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    print_r($row);


?>
<html lang="en"> 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit School Record</title>
        <link rel="stylesheet" href="../../css/admin.css">
    </head>
<body>
    
    <div id="container">
        <header id="header">
            <h2 id='title'>Edit School Record</h2> 
            <a href=../logoff.php class='button-like-link'>Logout</a>
        </header>
        <?php include('sidebar.html'); ?>
        <div id='main_section'>
            <table id='record_list_table'>
                <th class='record_list_header'>Name</th>
                <th class='record_list_header'>City</th>
                <th class='record_list_header'>State</th>
                <th class='record_list_header'>Postal Code</th>
                <form id='editForm' action='process_school_record.php' method='post'>
                    <tr id='record_row'>
 
                <?php
                    echo "
                        <td class='record_list_data'><input class='edit-input' type='text' name='name' value='$row[name]'></td>
                        <td class='record_list_data'><input class='edit-input' type='text' name='city' value='$row[city]'></td>
                        <td class='record_list_data'><input class='edit-input' type='text' name='state' value='$row[state]'></td>
                        <td class='record_list_data'><input class='edit-input' type='text' name='postal_code' value='$row[postal_code]'></td>
                    ";
                ?>
                </tr>
                    <tr>
                        <td><input type="hidden" name='school_id' value='<?php echo $row['school_id']; ?>'></td>
                        <td><input class='edit-button' type='submit' name='command' value='update'></td>
                        <td><input class='edit-button' type='submit' name='command' value='delete'></td>
                        <td colspan='2'><input class='edit-button' type='button' name='command' value='reset' onclick='resetForm()'></td>
                    </tr>
                    
                </form>
        </table>
        </div>
        <div id="footer"><?php include_once("../footer.php"); ?></div>
    </div>
    <script>
        function resetForm() {
            document.getElementById('editForm').reset();
        }
    </script>
</body>
</html>

<?php mysqli_close($conn); ?>