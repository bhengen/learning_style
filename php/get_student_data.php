<?php
    // script to get the individual student to automatically populate the from 
    // the index.php page
    
    header('Content-Type: application/json');

    // connect to the database
    include('db.php');

    // get the studentId to search
    $studentId = $_POST['studentId'];
 
    // Your SQL query
    $query = "SELECT * FROM students where student_id = $studentId";

    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result) {

        // Fetch the result rows as an associative array
        $rows = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        
        // Convert the associative array to JSON
        $jsonString = json_encode($rows);

        // Output the JSON string
        echo $jsonString;

        file_put_contents('output.json', $jsonString);
       
    } else {
        // Handle the case when the query fails
        echo "Error fetching data: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);

?>