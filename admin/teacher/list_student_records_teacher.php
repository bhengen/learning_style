<!DOCTYPE html>
<?php

    // error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../../php/db.php');

    $query = "SELECT * FROM students ORDER BY student_id";
    $result = mysqli_query($conn, $query);

?>
<html lang="en"> 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Student Record Listing</title>
        <link rel="stylesheet" href="../../css/admin.css">
    </head>
<body>
    
    <div id="container">
        <header id="header" class="header_container">
            <h2 id='title'>Student Record List </h2> 
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
                <?php
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr id='record_row'>";
                        echo "
                            <td class='record_list_data'>
                                <a href='edit_student_record_teacher.php?student_id=$row[student_id]' id='tdata'>$row[student_id]</a></td>
                            <td class='record_list_data'>$row[first_name]</td>
                            <td class='record_list_data'>$row[last_name]</td>
                            <td class='record_list_data'>$row[class_period]</td>
                            <td class='record_list_data'>$row[school_name]</td>
                            <td class='record_list_data'>$row[state]</td>
                        ";
                        echo "</tr>";
                    };
                ?>
        </table>
        </div>
        <div id="footer"><?php include_once("../footer.php"); ?></div>
    </div>
   <!--<script src="../scripts/admin.js"></script>-->
</body>
</html>

<?php mysqli_close($conn); ?>