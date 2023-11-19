<?php
include ("db.php");
// program to display the student records as cards on the web page

// add a blank card at the beginning to add the capability to add a student
// check if blank card is displayed
if(!isset($_SESSION['blank_card_displayed'])) {
    echo "<div class='student-row'>";
        echo "<form action='php/process_student.php' method='post'>";
            echo "<input type='hidden' name='submit_action' value='add'>";

            echo "<label for='student_id'>Student Id:</label>";
            echo "&nbsp;&nbsp";
            echo "<input type='text' name='student_id' required>";
            echo "<br/><br/>";
            echo "<label for='first_name'>First Name:</label>";
            echo "&nbsp;&nbsp";
            echo "<input type='text' name='first_name' required>";
            echo "<br/><br/>";
            echo "<label for='last_name'>Last Name:</label>";
            echo "&nbsp;&nbsp";
            echo "<input type='text' name='last_name' required>";
            echo "<br/><br/>";
            echo "<label for='class_period'>Class Period:</label>";
            echo "&nbsp;&nbsp";
            echo "<input type='text' name='class_period' required>";
            echo "<br/><br/>";
            echo "<div class='button-container'>";
            echo "<input type='submit' value='Add Student' class='submit'>";
            echo  "</div>";
        echo "</form>";
    echo "</div>";
    
    // set the session variable to indicate that the blank form already was loaded
    $_SESSION['blank_card_displayed'] == true;

}

// Fetch data from the student table and build the remaining cards
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
                echo "<label for='first_name'>First Name:</label>";
                echo "&nbsp;&nbsp";
                echo "<input type='text' name='first_name' value='{$row['first_name']}' required>";
                echo "<br/><br/>";
                echo "<label for='last_name'>Last Name:</label>";
                echo "&nbsp;&nbsp;";
                echo "<input type='text' name='last_name' value='{$row['last_name']}' required>";
                echo "<br/><br/>";
                echo "<label for='class_period'>Class Period:</label>";
                echo "&nbsp;&nbsp;";
                echo "<input type='text' name='class_period' value='{$row['class_period']}' required>";
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