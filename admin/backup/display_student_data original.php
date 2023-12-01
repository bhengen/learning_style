<?php
    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include("../php/db.php"); // make a connection to the database

    $_SESSION['blank_card_displayed'] = $_SESSION['blank_card_displayed'] ?? false; // set the initial blank card flag to false
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../css/student_list.css" rel="stylesheet">
    <title>Student Data Processing Form</title>
</head>

<body>

    <h1>Student Modification Form</h1>
    <div class="container">

        <?php function generateStudentForm($action, $data = []) { ?>
            
            <div class='student-row'>
            <form action='update_student_record.php' method='post' 'id='studentForm' onsubmit='return handleFormSubmit()' ?>
            <input type='hidden' name='submit_action' value='<?php echo $action; ?>'>
                    <?php foreach ($data as $key => $value): ?>
                        <label for='<?php echo $key; ?>'><?php echo ucwords(str_replace('_', ' ', $key)); ?>:</label>
                        &nbsp;&nbsp;
                        <input type='text' name='<?php echo $key; ?>' value='<?php echo $value;?>' required>             
                        <br/><br/>
                    <?php endforeach; ?>
                    <div class='button-container'>
                        <input type='submit' value='update' class='submit' id='updateBtn' name='submit_action'>
                        <?php if ($action === 'delete'): ?>                          
                            <input type='submit' value='delete' class='submit' id='deleteBtn' name='submit_action'>
                        <?php endif; ?>

                        <!-- Add a hidden input to store the action -->
                        <!--<input type='hidden' name='submit_action' id='submit_action' value=''>-->

                    </div>
                </form>
            </div>
        <?php } ?>

        <?php function addBlankCard($action, $data = []) { ?>
            <div class='student-row'>
                <form action='update_student_record.php' method='post' id='studentForm'>
                    <input type='hidden' name='submit_action' value='<?php echo $action; ?>'>
                    <?php foreach ($data as $key => $value): ?>
                        <label for='<?php echo $value; ?>'><?php echo $value; ?></label>
                        &nbsp;&nbsp;
                        <?PHP if(stripos($value, 'period')) { ?>
                            <input type='text' name='<?php echo $value; ?>' 
                                value='' required pattern='[1-6]+'
                                title='please enter a number betwween 1 & 6'>
                        <?PHP } else { ?>
                            <input type='text' name='<?php echo $value; ?>' value='' required>
                        <?PHP } ?>        
                        <br/><br/>
                    <?php endforeach; ?>
                    <div class='button-container'>
                        <input type='submit' value='<?php echo $action; ?>' class='submit' name='submit_action'>
                    </div>
                </form>
            </div>    
        <?php } ?>

        <?php
            // Display a blank card for adding a new student
            $addFields = ['student_id','first_name', 'last_name', 'class_period', ];

            addBlankCard('add', $addFields);

            // Fetch data from the student table and build the remaining cards
            $query = "SELECT * FROM students ORDER BY last_name";
            $result = mysqli_query($conn, $query);

            // Check if the query was successful
            if ($result) {
                // Fetch and display each row
                while ($row = mysqli_fetch_assoc($result)) {
                    // Get the keys from the row associative array
                    //$updateFields = array_keys($row);
                    generateStudentForm('delete', $row);
                }
            } else {
                // Handle the case when the query fails
                echo "Error fetching data: " . mysqli_error($conn);
            }

            // Close the database connection
            mysqli_close($conn);
        ?>
    </div>

    <script>
        function handleFormSubmit() {
            var submitAction;

            if (document.activeElement.id === 'updateBtn') {
                // Update button clicked
                submitAction = 'update';
            } else if (document.activeElement.id === 'deleteBtn') {
                // Delete button clicked
                var confirmed = confirm("Are you sure you want to delete this record?");
                if (confirmed) {
                    submitAction = 'delete';
                } else {
                    // Cancel clicked, prevent form submission
                    return false;
                }
            }

            // Set the action in a hidden input field
            document.getElementById('submit_action').value = submitAction;

            // Continue with form submission
            return true;
        }
</script>
</body> 
</html>