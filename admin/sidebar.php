<?PHP

    $page = $_SESSION['page'];
    echo "<div id='side-container'>
           <div id='left'></div>
           <div id='right'>
            <ul id='menu'>
    ";
            if($page === 'admin') {
                echo "<li class='item' data-page='list_teacher_records'>List Teacher</li>
                      <li class='item' data-page='process_students'>Teacher Maintenance</li>
                      <li class='item' data-page='process_students'>List Student</li>
                      <li class='item' data-page='process_students'>Student Maintenance</li>";
        
            } else if ($page === 'teacher') {
                echo "<li class='item' data-page='list_students'>List Student</li>
                      <li class='item' data-page='process_students'>Student Maintenance</li>";
              } else {
                // display nothing
            }
    echo "
            </ul>
        </div>
      </div>";
?>