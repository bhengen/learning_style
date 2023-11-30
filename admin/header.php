<?PHP
    $page = $_SESSION['page'];

    echo "<div class='header_container'>";
        if($page === 'teacher') {
            echo "<h2 class='title'>Teacher Administration Page</h2>"; 
        } else if($page === 'student') {
            echo "<h2 class='title'>Student Administration Page</h2>";
        } else {
            echo "<h2 class='title'>Teacher / Admin Login Page</h2>";
        }
        echo "<a href=logoff.php class='button-like-link'>Logout</a>";
    echo "</div>";   
?>