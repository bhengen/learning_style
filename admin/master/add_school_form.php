<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add School Form</title>
        <link rel="stylesheet" href="../../css/admin.css">
    </head>

    <body>
        <div id="container">
            <header id="header" class="header-container">
                <h2 id='title'>Add School Form </h2> 
                <a href='../logoff.php' class='button-like-link'>Logout</a>
            </header>
            <?php include('sidebar.html'); ?>
            <div id='main-section'>
            <table id='record-list-table'>
                <th class='record-list-header'>School Name</th>
                <th class='record-list-header'>School City</th>
                <th class='record-list-header'>School State</th>
                <th class='record-list-header'>School Postal Code</th>
                <form id='editForm' action='add_school_record.php' method='post'>
                    <tr id='record_row'>
                        <td class='edit-list-data'><input class='edit-input' type='text' name='name' required></td>
                        <td class='edit-list-data'><input class='edit-input' type='text' name='city' required></td>
                        <td class='edit-list-data'><input class='edit-input' type='text' name='state' required></td>
                        <td class='edit-list-data'><input class='edit-input' type='text' name='postal_code' required></td>
                    </tr>
                    <tr>
                        <td colspan='2'><input class='edit-button' type='submit' value='add' name='add'></td>
                        <td colspan='2'><input class='edit-button' type='button'  value='reset' onclick='resetForm()'></td>
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