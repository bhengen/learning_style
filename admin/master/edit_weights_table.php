<!DOCTYPE html>
<?php

    // error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../../php/db.php');

    $question_number = $_GET['question_number'];

    $query = "SELECT * FROM weights where question_number='$question_number'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);


?>
<html lang="en"> 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Weight Table</title>
        <link rel="stylesheet" href="../../css/admin.css">
    </head>
<body>
    
    <div id="container">
        <header id="header">
            <h2 id='title'>Edit Weight Table</h2> 
            <a href=../logoff.php class='button-like-link'>Logout</a>
        </header>
        <?php include('sidebar.html'); ?>
        <div id='main_section'>
            <table id='record_list_table'>
                <th class='record_list_header'>Question Number</th>
                <th class='record_list_header' colspan='2'>Weight</th>
                <form id='editForm' action='process_weights_table.php' method='post'>
                    <tr id='record_row'>
                <?php
                    echo "
                        <td class='record_list_data'><input class='edit-input' type='text' name='question_number' value='$row[question_number]'></td>
                        <td class='record_list_data' colspan='2'><input class='edit-input' type='text' name='weight' value='$row[weight]'></td>
                    ";
                ?>
                </tr>
                    <tr>
                        <td><input class='edit-button' type='submit' name='command' value='update'></td>
                        <td><input class='edit-button' type='submit' name='command' value='delete'></td>
                        <td><input class='edit-button' type='button' name='command' value='reset' onclick='resetForm()'></td>
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