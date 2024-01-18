<!DOCTYPE html>
<?php
    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../php/db.php');
    
    // Set the page based on a request parameter or session variable
    $page = isset($_POST['page']) ? $_POST['page'] : (isset($_SESSION['page']) ? $_SESSION['page'] : 'login');
    $_SESSION['page'] = $page;

    // Check if there is an error message
    if (isset($_SESSION['error'])) {
        $errorMessage = $_SESSION['error'];
        echo '<div style="color: red;">' . $errorMessage . '</div>';

        // Clear the error message from the session to show it only once
        unset($_SESSION['error']);
    }


?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/student_list.css">

    <?php 
        if($page === 'admin') {
            echo "<title>Teacher Admin Page</title>";
        } else if ($page === "teacher") {
            echo "<title>Student Admin Page</title>"; 
         } else { 
            echo "<title>Login Page</title>";
        }
    ?>
</head>
<body>
    <div id="container">
        <header id="header" class="header_container">
            <h2 id='title'>Teacher / Student Administration Page</h2> 
            <a href=logoff.php class='button-like-link'>Logout</a>
        </header>
        <div id="sidebar">
            <?php include_once("sidebar.php"); ?>
        </div>
        <div id="main_section">
            <?php
                // Check if there is an error message
                if (isset($_GET['error'])) {
                    $errorMessage = urldecode($_GET['error']);
                    echo '<div style="color: red;">' . $errorMessage . '</div>';
                }
            ?>

            <form id="loginForm" action="login_process.php" method="post">
                <label for="teacherId" class="label">Teacher Id:
                    <input type="text" name="teacherId" required />
                </label>
                <br/>
                <label for="teacherFirstName" class="label">First Name:
                <input type="text" name="teacherFirstName" required /></label>
                <br/>
                <label for="teacherLastName" class="label">Last Name:
                <input type="text" name="teacherLastName" required /></label>
                <br/>
                <button type="submit">Login</button>
            </form>

        </div>
        <div id="footer">
            <?php include_once("footer.php"); ?>
        </div>
    </div>
    <script src="../scripts/admin.js"></script>
</body>
</html>