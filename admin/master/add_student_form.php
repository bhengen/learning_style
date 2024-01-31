<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Student Form</title>
        <link rel="stylesheet" href="../../css/admin.css">
    </head>

    <body>
        <div id="container">
            <header id="header" class="header-container">
                <h2 id='title'>Add Student Form </h2> 
                <a href='../logoff.php' class='button-like-link'>Logout</a>
            </header>
            <?php include('sidebar.html'); ?>
            <div id='main-section'>
            <table id='record-list-table'>
                <th class='record-list-header'>Student Id</th>
                <th class='record-list-header'>First Name</th>
                <th class='record-list-header'>Last Name</th>
                <th class='record-list-header'>School Name</th>
                <th class='record-list-header'>Class Period</th>
                <th class='record-list-header'>City</th>
                <th class='record-list-header'>State</th>
                <th class='record-list-header'>Postal Code</td>
                <form id='editForm' action='add_student_record.php' method='post'>
                    <tr id='record_row'>
                        <td class='edit-list-data'><input class='edit-input' type='text' name='student_id' required></td>
                        <td class='edit-list-data'><input class='edit-input' type='text' name='first_name' required></td>
                        <td class='edit-list-data'><input class='edit-input' type='text' name='last_name' required></td>
                        <td class='edit-list-data'><input class='edit-input' type='text' name='school_name' required></td>
                        <td class='edit-list-data'>
                            <select id='option-select' name='class_period' required>
                                <?php for($i = 1; $i < 7; $i++ ) {
                                    echo "<option value = $i>$i</option>";
                                } ?>
                            </select>
                        </td>
                        <td class='edit-list-data'><input class='edit-input' type='text' name='city' required></td>
                        <td class='edit-list-data'><input class='edit-input' type='text' name='state' required></td>
                        <td class='edit-list-data'><input class='edit-input' type='text' name='postal_code' required></td>
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