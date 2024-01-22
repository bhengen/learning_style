<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Image Form</title>
        <link rel="stylesheet" href="../../css/admin.css">
    </head>

    <body>
        <div id="container">
            <header id="header" class="header_container">
                <h2 id='title'>Add Image Form </h2> 
                <a href='../logoff.php' class='button-like-link'>Logout</a>
            </header>
            <?php include('sidebar.html'); ?>
            <div id='main_section'>
            <table id='record_list_table'>
                <th class='record_list_header'>Image Name</th>
                <th class='record_list_header'>Image URL</th>
                <th class='record_list_header'>Label</th>
                <form id='editForm' action='add_image_record.php' method='post'>
                    <tr id='record_row'>
                        <td class='edit_list_data'><input class='edit-input' type='text' name='image_name' required></td>
                        <td class='edit_list_data'><input class='edit-input' type='text' name='image_url' required></td>
                        <td class='edit_list_data'><input class='edit-input' type='text' name='label' required></td>
                        <td class='edit_list_data'><input class='edit-input' type='text' name='city' required></td>
                        <td class='edit_list_data'><input class='edit-input' type='text' name='state' required></td>
                        <td class='edit_list_data'><input class='edit-input' type='text' name='postal_code' required></td>
                    </tr>
                    <tr>
                        <td colspan='4'><input class='edit-button' type='submit' value='add' name='add'></td>
                        <td colspan='4'><input class='edit-button' type='button'  value='reset' onclick='resetForm()'></td>
                    </tr>
                    
                </form>
        </table>
        </div>
        <div id="footer"><?php include_once("../footer.php"); ?></div>
        <script>
            function resetForm() {
                document.getElementById('editForm').reset();
            } 
        </script>
    </body>
</html>