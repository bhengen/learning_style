<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add Weight Form</title>
        <link rel="stylesheet" href="../../css/admin.css">
    </head>

    <body>
        <div id="container">
            <header id="header" class="header_container">
                <h2 id='title'>Add Weight Form </h2> 
                <a href='../logoff.php' class='button-like-link'>Logout</a>
            </header>
            <?php include('sidebar.html'); ?>
            <div id='main-section'>
            <table id='record-list-table'>
                <th class='record-list-header'>Question Number</th>
                <th class='record-list-header'>Weight</th>

                <form id='editForm' action='add_weight_record.php' method='post'>
                    <tr id='record-row'>
                        <td class='edit-list-data'>
                            <input class='edit-input' type='text' name='question_number' required>
                            <select id='option-select' name='option_selected'>
                                <option>A</option>
                                <option>B</option>
                            </select required>
                        </td>
                        <td class='edit-list-data'><input class='edit-input' type='text' name='weight' required></td>
                    </tr>
                    <tr>
                        <td><input class='edit-button' type='submit' value='add' name='add'></td>
                        <td><input class='edit-button' type='button'  value='reset' onclick='resetForm()'></td>
                    </tr>
                    
                </form>
        </table>
        </div>
                <div id="footer"><?php include_once("../footer.php"); ?></div>
    </body>
</html>