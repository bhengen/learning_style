<?PHP
    $page = $_SESSION['page'];

    echo "<div class='header_container'>";
        if($page === 'admin') {
            echo "<h2 id='title'>Teacher / Student Administration Page</h2>"; 
        } else if($page === 'teacher') {
            echo "<h2 id='title'>Student Administration Page</h2>";
        } else {
            echo "<h2 id='title'>Teacher / Admin Login Page</h2>";
        }
        echo "<a href=logoff.php class='button-like-link'>Logout</a>";
    echo "</div>";   
?>