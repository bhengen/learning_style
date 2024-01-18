<!DOCTYPE html>
<?php

    // error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../../php/db.php');

    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'student_id'; // Default sorting by student_id
    $order = isset($_GET['order']) ? $_GET['order'] : 'asc'; // default sort ascending order
    $query = "SELECT * FROM students ORDER BY $sort $order";
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
            <a href='../logoff.php' class='button-like-link'>Logout</a>
        </header>
        <?php  include('sidebar.html'); ?>
        <div id='main_section'>
            <table id='record_list_table'>
                <th class='record_list_header'>
                    <a id='sort-link' href='?sort=student_id&order=desc'> << </a>
                        Student Id
                    <a id='sort-link' href='?sort=student_id&order=asc'> >> </a>
                </th>
                <th class='record_list_header'>
                    <a id='sort-link' href='?sort=first_name&order=desc'> << </a>
                        First Name
                    <a id='sort-link' href='?sort=first_name&order=asc'> >> </a>
                </th>
                <th class='record_list_header'>
                    <a id='sort-link' href='?sort=last_name&order=desc'> << 
                        Last Name
                    <a id='sort-link' href='?sort=last_name&order=asc'> >> </a>
                </th>
                <th class='record_list_header'>
                    <a id='sort-link' href='?sort=class_period&order=desc'> << </a>
                        Class Period
                    <a id='sort-link' href='?sort=class_period&order=asc'> >> </a>
                </th>
                <th class='record_list_header'>
                    <a id='sort-link' href='?sort=school_name&order=desc'> << </a>
                        School Name
                    <a id='sort-link' href='?sort=school_name&order=asc'> >> </a>
                </th>
                <th class='record_list_header'>
                    <a id='sort-link' href='?sort=city&order=desc'> << </a>
                        City
                    <a id='sort-link' href='?sort=city&order=asc'> >> </a>
                </th>
                <th class='record_list_header'>
                    <a id='sort-link' href='?sort=state&order=desc'> << </a>
                        State
                    <a id='sort-link' href='?sort=state&order=asc'> >> </a>
                </th>
                <th class='record_list_header'>
                    <a id='sort-link' href='?sort=postal_code&order=desc'> << </a>
                        Postal Code
                    <a id='sort-link' href='?sort=postal_code&order=asc'> >> </a>
                </th>
                <?php
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr id='record_row'>";
                        echo "
                            <td class='record_list_data'>
                                <a href='edit_student_record.php?student_id=$row[student_id]' id='tdata'>$row[student_id]</a></td>
                            <td class='record_list_data'>$row[first_name]</td>
                            <td class='record_list_data'>$row[last_name]</td>
                            <td class='record_list_data'>$row[class_period]</td>
                            <td class='record_list_data'>$row[school_name]</td>
                            <td class='record_list_data'>$row[city]</td>
                            <td class='record_list_data'>$row[state]</td>
                            <td class-'record_list_data'>$row[postal_code]</td>
                        ";
                        echo "</tr>";
                    };
                ?>
        </table>
        </div>
        <div id="footer">
                <?php include_once("../footer.php"); ?>
        </div>
    </div>
   <!--<script src="../scripts/admin.js"></script>-->
</body>
</html>

<?php mysqli_close($conn); ?>