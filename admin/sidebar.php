<?PHP

    $page = $_SESSION['page'];
    echo "<div id='side-container'>
           <div id='left'></div>
           <div id='right'>
            <ul id='menu'>
    ";
            if($page === 'admin') {
                echo "<li class='item' data-page='list-teacher'>List Teacher</li>
                      <li class='item' data-page='teacher-maintenance'>Teacher Maintenance</li>
                      <li class='item' data-page='display_student_data'>List Student</li>
                      <li class='item' data-page='display_student_data'>Student Maintenance</li>";
        
            } else if ($page === 'teacher') {
                echo "<li class='item' data-page='display_student_data'>List Student</li>
                      <li class='item' data-page='display_student_data'>Student Maintenance</li>";
              } else {
                // display nothing
            }
    echo "
            </ul>
        </div>
      </div>";
?>