<!DOCTYPE html>
<?php

    // error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../../php/db.php');

    $image_id = $_GET['image_id'];

    $query = "SELECT * FROM images where image_id='$image_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    $image_name = explode("images/",$row['image_url']);
    $image_name = array_pop($image_name);

?>
<html lang="en"> 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Image Record</title>
        <link rel="stylesheet" href="../../css/admin.css">
    </head>
<body>
    
    <div id="container">
        <header id="header">
            <h2 id='title'>Edit Image Record</h2> 
            <a href=../logoff.php class='button-like-link'>Logout</a>
        </header>
        <?php include('sidebar.html'); ?>
        <div id='main_section'>
            <table id='record_list_table'>
                <th class='record_list_header'>Image Name</th>
                <th class='record_list_header'>Image Url</th>
                <th class='record_list_header'>Question Number</th>

                <form id='editForm' action='process_image_record.php' method='post'>
                    <tr id='record_row'>
                <?php
                    echo "
                        <input type='hidden' name='image_id' value='$row[image_id]'>
                        <td class='record_list_data'><input class='edit-input' type='text' name='image_name' value='$row[image_name]'></td>
                        <td class='record_list_data'>
                            <input class='edit-input' type='text' name='image_url' value='images/".$image_name."'>
                        </td>
                        <td class='record_list_data'><input class='edit-input' type='text' name='question_number' value='$row[question_number]'></td>
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