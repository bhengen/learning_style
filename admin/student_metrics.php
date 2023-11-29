<?PHP

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include '../php/db.php';

    $total_questions = 28;
    

    // Get a list of all students
    $studentList = [];
    $student_query = "SELECT student_id FROM students";
    $students_result = mysqli_query($conn, $student_query);

    if ($students_result) {
        while($row = mysqli_fetch_row($students_result)) {
            $studentList[] = $row;
        }
    }

    echo "<h1>Students Completion Status</h1>";

    // Query to get completed questions for a specific student
    $completed_query = "SELECT questions_completed.student_id,
            concat(students.first_name,' ',students.last_name) as student_name,
            COUNT(question_number) AS questions_answered,
            (COUNT(question_number) / 28) * 100 AS pct_answered
        FROM questions_completed
        LEFT JOIN
            students ON students.student_id = questions_completed.student_id
        GROUP BY
            students.student_id
        ORDER BY
            questions_answered;";
    
        $completed_result = mysqli_query($conn, $completed_query);
 
        if($completed_result) {
            while($row = mysqli_fetch_assoc($completed_result)) {
                echo "Student Id: $row[student_id]". "&nbsp;";
                echo "Student Name: $row[student_name]". "&nbsp;";
                echo "Questions Answered: $row[questions_answered]"."&nbsp;";
                echo "Pct Answered: $row[pct_answered]". "<br/>";
            }   
       
        }

        echo "<br/>";
        
        // query to get a list of questions completed for the students 
        // that hasn't completed all of the questions
        $partial_completed_query = "SELECT
                                    students.student_id,
                                    CONCAT(students.first_name, ' ', students.last_name) AS student_name,
                                        answered_questions.question_number
                                FROM students
                                LEFT JOIN (
                                    SELECT student_id, question_number
                                    FROM questions_completed
                                ) AS answered_questions ON students.student_id = answered_questions.student_id
                                WHERE
                                    (SELECT COUNT(DISTINCT question_number) FROM 
                                        questions_completed WHERE student_id = students.student_id) < 28
                                    AND (SELECT COUNT(DISTINCT question_number) FROM 
                                        questions_completed WHERE student_id = students.student_id) > 0;";

        $partial_completed_result = mysqli_query($conn, $partial_completed_query);
       
        if($partial_completed_result) {
            while($row = mysqli_fetch_assoc($partial_completed_result)) {
                  echo "Student Id: $row[student_id]". "&nbsp;";
                  echo "Student Name: $row[student_name]". "&nbsp;";
                  echo "Questios Answered: $row[question_number]"."<br/>";
            }   
        }
        
        /// students not yet taken the assessment
       
        echo "<table>";
        $row_counter = 0;

        $students_not_completed = "SELECT students.student_id, CONCAT(students.first_name, ' ', students.last_name) AS student_name
                                    FROM students
                                    LEFT JOIN
                                        questions_completed ON students.student_id = questions_completed.student_id
                                    WHERE
                                        questions_completed.student_id IS NULL
                                    ORDER BY
	                                    student_name;";
        $students_not_result  = mysqli_query($conn, $students_not_completed);
        if ($students_not_result) {
            while ($row = mysqli_fetch_row($students_not_result)) {
                // Check if it's time to close the current row and start a new one
                if ($row_counter % 5 === 0) {
                    echo "<tr>"; // Start a new row
                }
                echo "<td>$row[1]</td>";
                $row_counter++;
                // Check if it's time to close the current row
                if ($row_counter % 5 === 0) {
                    echo "</tr>"; // Close the current row
                }
            }
            // If the last row is not complete, close it
            if ($row_counter % 5 !== 0) {
                echo "</tr>";
            }
        }
        echo "</table>";

        mysqli_close($conn);

?>