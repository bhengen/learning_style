<!DOCTYPE html>
<?php

    // error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../php/db.php');

    $query = "SELECT * FROM teachers ORDER BY last_name";
    $result = mysqli_query($conn, $query);

?>
<html lang="en"> 
    <head>
    <script src="../scripts/admin.js"></script>
    </head>
<body>
    <div id='result'></div>
    <table id='teacher_list_table'>
        <th class='teacher_list_header'>Teacher Id</th>
        <th class='teacher_list_header'>First Name</th>
        <th class='teacher_list_header'>Last Name</th>
        <th class='teacher_list_header'>Role</th>
        <?php
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr id='teacher_row'>";
                    echo "
                        <td class='teacher_list_data'>
                            <a href='update_teacher_record.php?tid=$row[teacher_id]' id='tdata'>$row[teacher_id]</a></td>
                        <td class='teacher_list_data'>$row[first_name]</td>
                        <td class='teacher_lsit_data'>$row[last_name]</td>
                        <td class='teacher_list_data'>$row[role]</td>
                    ";
                    echo "</tr>";
                };
        ?>
    </table>
</body>
</html>

<?php mysqli_close($conn); ?>