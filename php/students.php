<?php
include ("db.php");

// Fetch data from the student table
$query = "SELECT * FROM students order by last_name";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    // Fetch and display each row
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='student-row'>";
            echo "<form action='php/process_student.php' method='post' onSubmit='return confirmDelete()'>";
                echo "<input type='hidden' name='student_id' value='{$row['student_id']}'>";
                
                // Display input fields for updating information
                echo "<label>Student Id: ".$row['student_id']."</label>";
                echo "<br/><br/>";
                echo "<label for='update_first_name'>First Name:</label>";
                echo "&nbsp;&nbsp;";
                echo "<input type='text' name='update_first_name' value='{$row['first_name']}' required>";
                echo "<br/><br/>";
                echo "<label for='update_last_name'>Last Name:</label>";
                echo "&nbsp;&nbsp;";
                echo "<input type='text' name='update_last_name' value='{$row['last_name']}' required>";
                echo "<br/><br/>";
                echo "<label for='update_class_period'>Class Period:</label>";
                echo "&nbsp;&nbsp;";
                echo "<input type='text' name='update_class_period' value='{$row['class_period']}' required>";
                echo "<br/><br/>";    
                echo "<div class='button-container'>";
                    echo "<input type='submit' value='Update' class='submit' name='submit_action'>";
                    echo "<input type='hidden' name='submit_action' value='delete'>";
                    echo "<input type='submit' value='Delete' class='submit' name='submit_action'>";
                echo "</div>";
        
                echo "</form>";
        echo "</div>";
    }
} else {
    // Handle the case when the query fails
    echo "Error fetching data: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
?>
`