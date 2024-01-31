<!DOCTYPE html>
<?php

    // error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../../php/db.php');

    $student_id = $_GET['student_id'];

    $query = "SELECT * FROM students where student_id='$student_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);


?>
<html lang="en"> 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Student Record</title>
        <link rel="stylesheet" href="../../css/admin.css">
    </head>
<body>
    
    <div id="container">
        <header id="header">
            <h2 id='title'>Edit Student Record</h2> 
            <a href=../logoff.php class='button-like-link'>Logout</a>
        </header>
        <?php include('sidebar.html'); ?>
        <div id='main-section'>
            <table id='record-list-table'>
                <th class='record-list-header'>Student Id</th>
                <th class='record-list-header'>First Name</th>
                <th class='record-list-header'>Last Name</th>
                <th class='record-list-header'>Class Period</th>
                <th class='record-list-header'>School Name</th>
                <th class='record-list-header'>City</th>
                <th class='record-list-header'>State</th>
                <th class='record-list-header'>Postal Code</th>
                <form id='editForm' action='process_student_record.php' method='post'>
                    <tr id='record_row'>
                <?php
                    echo "
                        <td class='record-list-data><input class='edit-input' type='text' name='student_id' value='$row[student_id]'></td>
                        <td class='record-list-data><input class='edit-input' type='text' name='first_name' value='$row[first_name]'></td>
                        <td class='record-list-data><input class='edit-input' type='text' name='last_name' value='$row[last_name]'></td>
                        <td class='record-list-data'>
                            <select id='option-select' name='class_period'>
                    ";
                                for($i = 1; $i < 7; $i++) { 
                                    if($i == $row['class_period']) {
                                        echo "<option value='$row[class_period]' selected> $row[class_period] </option>";
                                    } else {
                                        echo "<option value='$i'> $i </option>";
                                    }
                                }
                    echo "
                            </select>
                        </td>
                        <td class='record-list-data><input class='edit-input' type='text' name='city' value='$row[city]'></td>
                        <td class='record-list-data><input class='edit-input' type='text' name='school_name' value='$row[school_name]'></td>
                        <td class='record-list-data><input class='edit-input' type='text' name='state' value='$row[state]'></td>
                        <td class='record-list-data><input class='edit-input' type='text' name='postal_code' value='$row[postal_code]'></td>
                    ";
                ?>
                </tr>
                    <tr>
                        <td colspan='3'><input class='edit-button' type='submit' name='command' value='update'></td>
                        <td colspan='3'><input class='edit-button' type='submit' name='command' value='delete'></td>
                        <td colspan='3'><input class='edit-button' type='button' name='command' value='reset' onclick='resetForm()'></td>
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