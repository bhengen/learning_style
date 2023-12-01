<!DOCTYPE html>
<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../php/db.php');

// Set the page based on a request parameter or session variable
$page = isset($_POST['page']) ? $_POST['page'] : (isset($_SESSION['page']) ? $_SESSION['page'] : 'login');
$_SESSION['page'] = $page;

// Include update logic if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'update_student_record.php';
}

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/student_list.css">

    <?php 
    if ($page === 'admin') {
        echo "<title>Teacher Admin Page</title>";
    } elseif ($page === "teacher") {
        echo "<title>Student Admin Page</title>"; 
    } else { 
        echo "<title>Login Page</title>";
    }
    ?>
</head>
<body>
    <div id="container">
        <header id="header">
            <?php include_once("header.php"); ?>
        </header>
        <div id="sidebar">
            <?php include_once("sidebar.php"); ?>
        </div>
        <div id="main_section">
            <?php
            // Display result if the session variable is set
            if (isset($_SESSION['display_result'])) {
                include_once('update_result.php');  // Create a new file update_result.php for displaying the result
                unset($_SESSION['display_result']); // Reset the session variable
            } else {
                // Display the appropriate content based on the page
                if ($page === 'admin') {
                    include_once('teacher_admin.php');
                } elseif ($page === 'teacher') {
                    include_once('student_admin.php');
                } else {
                    include_once('admin_login.html');
                }
            }
            ?>
        </div>
        <div id="footer">
            <?php include_once("footer.php"); ?>
        </div>
    </div>
    <script src="../scripts/admin.js"></script>
</body>
</html>
