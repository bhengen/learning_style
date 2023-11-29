<?PHP
    $page = $_SESSION['page'];

    echo "<div>";
    if($page === 'teacher') {
         echo "<p>Teacher Administration Page</p>";
    } else if($page === 'student') {
        echo "<p>Student Administration Page</p>";
    } else {
        echo "<p>Teacher / Admin Login Page</p>";
    }
 
    echo "</div>";   
?>