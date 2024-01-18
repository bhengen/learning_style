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
        <div id="sidebar">
                <div id='side-container'>
                    <div id='left'></div>
                    <div id='right'>
                        <ul id='menu'>
                            <li class='item'>
                                <a id='sidebar-link' href="list_student_records_teacher.php">List Student</a>
                            </li>
                            <li class='item'> 
                                <a id='sidebar-link' href="#">Student Maintenance</a>
                            </li>
                        </ul>
                    </div>
                </div>
        </div>
        <div id='main_section'>
            <table id='record_list_table'>
                <th class='record_list_header'>Student Id</th>
                <th class='record_list_header'>First Name</th>
                <th class='record_list_header'>Last Name</th>
                <th class='record_list_header'>Class Period</th>
                <th class='record_list_header'>School Name</th>
                <th class='record_list_header'>State</th>
                <form  id='editForm' action='process_student.php' method='post'>
                    <tr id='record_row'>
                <?php
                        echo "
                            <td class='record_list_data'><input class='edit-input' type='text' value='$row[student_id]'></td>
                            <td class='record_list_data'><input class='edit-input' type='text' value='$row[first_name]'></td>
                            <td class='record_list_data'><input class='edit-input' type='text' value='$row[last_name]'></td>
                            <td class='record_list_data'><input class='edit-input' type='text' value='$row[class_period]'></td>
                            <td class='record_list_data'><input class='edit-input' type='text' value='$row[school_name]'></td>
                            <td class='record_list_data'><input class='edit-input' type='text' value='$row[state]'></td>

                        ";
                ?>
                </tr>
                    <tr>
                        <td colspan='2'><input class='edit-button' type='button' value='update'></td>
                        <td colspan='2'><input class='edit-button' type='button'  value='delete'></td>
                        <td colspan='2'><input class='edit-button' type='button'  value='reset' onclick='resetForm()'></td>
                    </tr>
                    
                </form>
        </table>
        </div>
        <div id="footer"><?php include_once("../../footer.php"); ?></div>
    </div>
    <script>
        function resetForm() {
            document.getElementById('editForm').reset();
        }
    </script>
</body>
</html>

<?php mysqli_close($conn); ?>