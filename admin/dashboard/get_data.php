<?php
    // error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../../php/db.php');


    // Calculate percentages for each student and the question number not completed
    $query = "SELECT
                s.student_id,
                CONCAT(s.first_name, ' ', s.last_name) AS student_name,
                ROUND((COUNT(DISTINCT qc.question_number) / 28) * 100, 0) AS pct_completed,
                GROUP_CONCAT(DISTINCT q.numeric_question_id) AS unanswered_questions
            FROM
                students s
            LEFT JOIN
            questions q ON NOT EXISTS (
                SELECT 1
                FROM questions_completed qc
                WHERE s.student_id = qc.student_id
                AND q.numeric_question_id = LEFT(qc.question_number, LENGTH(qc.question_number) - 1)
            )
            LEFT JOIN
                questions_completed qc ON s.student_id = qc.student_id
            WHERE
                s.student_id IN (
                SELECT
                    student_id
                FROM
                    questions_completed
                GROUP BY
                    student_id
                HAVING
                    COUNT(question_number) < 28
            )
            GROUP BY
                s.student_id
            ORDER BY
                student_id;
        ";
    
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $percent_completed[] = array(
            'student_id' => $row['student_id'],
            'student_name' => $row['student_name'],
            'pct_completed' => $row['pct_completed'],
            'unanswered_questions' => $row['unanswered_questions']
        );
    }


    // get the most answered selection from the questions_completed table
    $query = "SELECT question_number, COUNT(*) AS answer_count 
        FROM questions_completed 
        GROUP BY question_number 
        ORDER BY answer_count DESC;";
    $result = mysqli_query($conn, $query);
    $mostAnsweredQuestions = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $mostAnsweredQuestions[$row['question_number']] = $row['answer_count'];
    }


    // get the option (a or b) selected most by each student
    $query = "SELECT qc.student_id, CONCAT(first_name, ' ', last_name) AS student_name, 
            RIGHT(question_number, 1) AS selected_option, COUNT(*) AS option_count 
        FROM questions_completed qc 
        LEFT JOIN students s 
        ON s.student_id = qc.student_id 
        GROUP BY qc.student_id, selected_option 
        ORDER BY qc.student_id, selected_option ASC;";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $mostAnsweredOption[] = array(
            'student_id' => $row['student_id'],
            'student_name' => $row['student_name'],
            'selected_option' => $row['selected_option'],
            'option_count' => $row['option_count']
        );
    }

    // get the total option count for a and by by student
    $query = "SELECT 
            CONCAT(first_name, ' ', last_name) AS student_name, 
            COALESCE(SUM(RIGHT(qc.question_number,1) = 'A'),0) AS total_option_a, 
            COALESCE(SUM(RIGHT(qc.question_number,1) = 'B'),0) AS total_option_b,
            COALESCE(SUM(RIGHT(qc.question_number,1) = 'A') + SUM(RIGHT(qc.question_number,1) = 'B'),0) as column_total
        FROM questions_completed qc 
        LEFT JOIN students s 
        ON qc.student_id = s.student_id 
        GROUP BY student_name 
        HAVING total_option_a > 0 OR total_option_b > 0
        ORDER BY last_name; 
    ";

    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $mostAnsweredOptionByStudent[] = array(
            'student_name' => $row['student_name'],
            'total_option_a' => $row['total_option_a'],
            'total_option_b' => $row['total_option_b'],
            'column_total' => $row['column_total']
        );    
    }
    
    
    // get the option (a or b) selected most by period   
    $query = "SELECT class_period,
                    COALESCE(SUM(RIGHT(qc.question_number,1) = 'A'),0) AS total_option_a,
                    COALESCE(SUM(RIGHT(qc.question_number,1) = 'B'),0) AS total_option_b,
                    COALESCE(SUM(RIGHT(qc.question_number,1) = 'A') + SUM(RIGHT(qc.question_number,1) = 'B'),0) as column_totals                   
            FROM
                students s
            LEFT JOIN
	            questions_completed qc
            ON
	            qc.student_id = s.student_id 
            GROUP BY
                class_period;
            
    ";
        
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $mostAnsweredOptionByPeriod[] = array(
            'class_period' => $row['class_period'],
            'total_option_a' => $row['total_option_a'],
            'total_option_b' => $row['total_option_b'],
            'column_total' => $row['column_totals']
        );
    }



    // Encode the results as JSON for JavaScript consumption
    $output = [
        'percentCompleted' => $percent_completed,
        'mostAnsweredQuestions' => $mostAnsweredQuestions,
        'mostAnsweredOption' => $mostAnsweredOption,
        'mostAnsweredOptionByStudent' => $mostAnsweredOptionByStudent,
        'mostAnsweredOptionByPeriod' => $mostAnsweredOptionByPeriod
    ];

    echo json_encode($output);
    
?>