<!DOCTYPE html>
<?php

    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../../php/db.php');    

?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admininstration Area</title>
        <link rel="stylesheet" href="../../css/admin.css">
    </head>
    <body>
        <div id="container">
            <header id="header" class="header_container">
                <h2 id='title'>Student Administration Page</h2> 
                <a href=../logoff.php class='button-like-link'>Logout</a>
            </header>
            <div id="sidebar">
                <div id='side-container'>
                    <div id='left'></div>
                    <div id='right'>
                        <ul id='menu'>
                            <li class='item'>
                                <a id='sidebar-link' href="list_student_records_teacher.php">List Student</a>
                            </li>
                            <li class='item'> 
                                <a id='sidebar-link' href="#">Student Maintenance</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div id='main_section'>
                <h2>This is the main admin area</h2><br/>
                <p>Please select an item from the menu on the left</p>
            </div>
            <div id="footer">
                <?php include_once("../footer.php"); ?>
            </div>
        </div>
    </body>
</html>