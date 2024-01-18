<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    // connect to the database
    include('db.php');

    //print_r($_POST);

    $student_id = $_POST['studentId'];
    $pictureNumber = $_POST['pictureNumber'];
    $schoolYear = $_POST['school_year'];

    $piclength = strlen($pictureNumber);

    $query  = "SELECT question_number FROM questions_completed 
                        WHERE student_id='$student_id' 
                        AND completed_year='$schoolYear'
                        AND left(question_number,$piclength)='$pictureNumber'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_column($result);
    } else {
        echo "error ";
    }
    echo $row;
    //echo "hello";



?>