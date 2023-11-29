<?PHP

    $page = $_SESSION['page'];
    echo "<div>
            <ul>
    ";
            if($page === 'teacher') {
                echo "<li class='item'>List Student</li>
                      <li class='item'>Student Maintenance</li>";
        
            } else if ($page === 'studenta') {
                echo "<li class='item'>List Student</li>
                <li class='item'>Student Maintenance</li>";
  
            } else {
                // display nothing
            }
    echo "
            </ul>
        </div>";
?>