<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Teacher Form</title>
        <link rel="stylesheet" href="../../css/admin.css">
    </head>

    <body>
        <div id="container">
            <header id="header" class="header_container">
                <h2 id='title'>Add Teacher Form </h2> 
                <a href='../logoff.php' class='button-like-link'>Logout</a>
            </header>
            <?php include('sidebar.html'); ?>
            <div id='main_section'>
            <table id='record_list_table'>
                <th class='record_list_header'>Teacher Id</th>
                <th class='record_list_header'>First Name</th>
                <th class='record_list_header'>Last Name</th>
                <th class='record_list_header'>Role</th>
                <th class='record_list_header'>School Name</th>
                <th class='record_list_header'>City</th>
                <th class='record_list_header'>State</th>
                <th class='record_list_header'>Postal Code</td>
                <form id='editForm' action='add_teacher_record.php' method='post'>
                    <tr id='record_row'>
                        <td class='edit_list_data'><input class='edit-input' type='text' name='teacher_id' required></td>
                        <td class='edit_list_data'><input class='edit-input' type='text' name='first_name' required></td>
                        <td class='edit_list_data'><input class='edit-input' type='text' name='last_name' required></td>
                        <td class='edit_list_data'>
                            <select id='option-select' name='role' required>
                                <option value='admin'>admin</option>
                                <option value='teacher'>teacher</option>
                            </select>
                        </td>
                        <td class='edit_list_data'><input class='edit-input' type='text' name='school_name' required></td>
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
    </body>
</html>