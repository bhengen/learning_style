<!DOCTYPE html>
<?php
    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../php/db.php');
    
    // Set the page based on a request parameter or session variable
    $page = isset($_POST['page']) ? $_POST['page'] : (isset($_SESSION['page']) ? $_SESSION['page'] : 'login');
    $_SESSION['page'] = $page;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
    <?php 
        if($page === 'teacher') {
            echo "<title>Teacher Admin Page</title>";
        } else if ($page === "student") {
            echo "<title>Student Page</title>"; 
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
            <?php if($page === 'teacher' ) {
                    include_once('teacher_admin.php');
                  } else if ($page === 'student') {
                    include_once('student_admin.php');
                  } else {
                    include_once('admin_login.html');
                  }
            ?>
        </div>
        <div id="footer">
            <?php include_once("footer.php"); ?>
        </div>
    </div>
</body>
</html>