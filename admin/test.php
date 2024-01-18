<!DOCTYPE html>
<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../php/db.php');

    //$teacher_id = $_GET['tid'];
    $teacher_id = 2;

    $query = "SELECT * FROM teachers WHERE teacher_id=$teacher_id";
    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_assoc($result);

    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $role = $row['role'];

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Update Form</title>
    <link rel="stylesheet" href="../css/test.css">
</head>
<body>
    <div id="container">
        <header id="header" class="header_container">
            <h2 id='title'>Teacher Update Form</h2> 
            <a href="logoff.php" class='button-like-link'>Logout</a>
        </header>
        <div id="sidebar">
        <div id='left'></div>
            <div id='right'>
                <ul id='menu'>
                    <li class='item'>
                        <a id='sidebar-link' href="list_teacher_records.php">List Teacher</a>
                    </li>
                    <li class='item'>
                        <a id='sidebar-link' href="#">Teacher Maintenance</a>
                    </li>
                    <li class='item'>
                        <a id='sidebar-link' href="list_student_records.php">List Student</a>
                    </li>
                    <li class='item'>
                       <a id='sidebar-link' href="#">Student Maintenance</a>
                    </li>
                </ul>
            </div>
        </div>
        <div id='main_section'>
            <form id="update_teacher_form">
                <label>Teacher Id</label>
                <input type="text" name="teacher_id" value="<?php echo $teacher_id; ?>">
                <label>First Name</label>
                <input type="text" name="first_name" value="<?php echo $first_name; ?>">
                <label>Last Name</label>
                <input type="text" name="last_name" value="<?php echo $last_name; ?>">
                <label>Role</label>
                <input type="text" name="role" value="<?php echo $role; ?>">
                <button name='submit' id='teacher_submit'>Update Record</button>
            </form> 
        </div>
        <div id="footer"><?php include_once("footer.php"); ?></div>
    </div>
</body>
</html>
