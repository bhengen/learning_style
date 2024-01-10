<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include('db.php');

    // Retrieve the selected values from the AJAX request
    print_r($_POST);

    $student_id = $_POST['studentId'];
    $question_answered = $_POST['question_number'];
    $completed_day = $_POST['completed_day'];
    $completed_month = $_POST['completed_month'];
    $completed_year = $_POST['completed_year'];
    $completed_hour = $_POST['completed_hour'];
    $completed_min = $_POST['completed_min'];
    $completed_sec = $_POST['completed_sec'];
    if(preg_match('/\d+/', $question_answered, $matches)) {
        $question_number = $matches[0];
    }
    
    $query = "SELECT idx FROM questions_tracked
        WHERE question_number 
        LIKE '%$question_number%' 
        AND student_id='$student_id'
        AND completed_year='$completed_year'";
    $result = mysqli_query($conn, $query);

    if($result->num_rows > 0 ) {

        $idx = mysqli_fetch_column($result);
        $updateQuery = "UPDATE questions_tracked
                        SET question_number = '$question_answered',
                        completed_hour = '$completed_hour',
                        completed_min = '$completed_min',
                        completed_sec = '$completed_sec'
                        WHERE idx = $idx AND completed_year = '$completed_year'";
        $updateResult = mysqli_query($conn, $updateQuery);

        if($updateResult) {
            echo 'record successfully update';
        } else {
            echo 'error updating record';
        }
    
    } else {

        // Insert into the questions_completed table
    
        $query = "INSERT INTO questions_tracked (
            student_id, 
            question_number,
            completed_day,
            completed_month,
            completed_year,
            completed_hour,
            completed_min,
            completed_sec
            ) 
            VALUES (
                '$student_id',
                '$question_answered',
                '$completed_day',
                '$completed_month',
                '$completed_year',
                '$completed_hour',
                '$completed_min',
                '$completed_sec'
                )";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            // Send a response back to the client (optional)
            echo 'Error inserted successfully';
    
            die("Error inserting record: " . mysqli_error($conn));
    
        } else {
    
            // Send a response back to the client (optional)
            echo 'Data inserted successfully';
    
        }
        
    }

    // Close the database connection
    mysqli_close($conn);

?>
