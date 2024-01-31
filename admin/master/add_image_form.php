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
            <header id="header" class="header-container">
                <h2 id='title'>Add Image Form </h2> 
                <a href='../logoff.php' class='button-like-link'>Logout</a>
            </header>
            <?php include('sidebar.html'); ?>
            <div id='main-section'>
            <table id='record-list-table'>
                <th class='record-list-header'>Image Name</th>
                <th class='record-list-header'>Image URL</th>
                <th class='record-list-header'>Question Number</th>
                <form id='editForm' action='add_image_record.php' method='post'>
                    <tr id='record_row'>
                        <td class='edit-list-data'>
                            <input class='edit-input' type='text' name='image_name' required oninput='updateQuestion()' id='image-name'>
                        </td>
                        <td class='edit-list-data'>images/<input class='edit-input' type='text' name='image_url' required></td>
                        <td class='edit-list-data'>
                            <input class='edit-input' type='text' name='question_number' required id='question-number'>
                            <select name='question_option' id='option-select'>
                                <option>a</option>
                                <option>b</option>
                            </select>   
                        </td>
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
    
            function updateQuestion() {
                // Get the value from the first input
                let image_name = document.getElementById('image-name').value;

                // Update the value of the second input
                document.getElementById('question-number').value = image_name;
            }
    </script>

    </body>
</html>