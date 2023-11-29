<?PHP

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include('db.php');

    // Retrieve the selected values from the AJAX request
    $student_id = $_POST['studentId'];
    $question_answered = $_POST['question_number'];
 
    if(preg_match('/\d+/', $question_answered, $matches)) {
        $question_number = $matches[0];
    }
    
    $query = "SELECT idx from questions_completed where question_number like '%$question_number%' and student_id='$student_id'";
    $result = mysqli_query($conn, $query);

    if($result->num_rows > 0 ) {

        $idx = mysqli_fetch_column($result);
        $updateQuery = "UPDATE questions_completed set question_number = '$question_answered' where idx = $idx";
        $updateResult = mysqli_query($conn, $updateQuery);

        if($updateResult) {
            echo 'record successfully update';
        } else {
            echo 'error updating record';
        }
    
    } else {

        // Insert into the questions_completed table
    
        $query = "INSERT INTO questions_completed (student_id, question_number) VALUES ('$student_id', '$question_answered')";
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
