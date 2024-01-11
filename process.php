<!DOCTYPE html>
<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include("php/db.php"); // make a connection to the database

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $timestamp = $_POST['timestamp'];
    $studentId = $_POST['studentId'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $classPeriod = $_POST['classPeriod'];
    $labels = explode(',',$_POST['selectedItems']);
    $completed_day = $_POST['completedDay'];
    $completed_month = $_POST['completedMonth'];
    $schoolYear = $_POST['schoolYear'];
    $completed_hour = $_POST['completedHour'];
    $completed_min = $_POST['completedMin'];
    $completed_sec = $_POST['completedSec'];

    $allQuery = "SELECT question_number, weight FROM weights";
    $allResult = mysqli_query($conn, $allQuery);

    $weights = [];
    $bins = [];
    $sum = 0;


    function updateOrInsertCompletedTable($conn, $studentId, $schoolYear, $digit, $val, $timestamp, $classPeriod, $completed_day, $completed_month, $completed_hour, $completed_min, $completed_sec) {
        // Use a prepared statement to prevent SQL injection
        $checkQuery = "SELECT 1 FROM questions_completed 
            WHERE student_id=? AND completed_year=? AND REGEXP_SUBSTR(question_number,'[0-9]+')=?";
        
        $stmt = mysqli_prepare($conn, $checkQuery);
        mysqli_stmt_bind_param($stmt, 'sss', $studentId, $schoolYear, $digit);
        mysqli_stmt_execute($stmt);

        $checkResult = mysqli_stmt_get_result($stmt);
        $existingRows = mysqli_num_rows($checkResult);
    
        if ($existingRows > 0) {
            $completedQuery = "UPDATE questions_completed SET 
                response_id='$timestamp', question_number='$val', completed_hour='$completed_hour',
                completed_min='$completed_min', completed_sec='$completed_sec'
                WHERE student_id='$studentId' AND completed_year='$schoolYear' AND REGEXP_SUBSTR(question_number,'[0-9]+')='$digit'";
            
            $queryResult = mysqli_query($conn, $completedQuery);
        } else {
            $query = "INSERT INTO questions_completed (
                    response_id, student_id, question_number, class_period, completed_day, completed_month, completed_year,
                    completed_hour, completed_min, completed_sec
                ) 
                VALUES ('$timestamp', '$studentId', '$val', '$classPeriod', '$completed_day', '$completed_month', '$schoolYear',
                    '$completed_hour', '$completed_min', '$completed_sec')";
            
            $queryResult = mysqli_query($conn, $query);
        }
    
        return $queryResult;
    }
    
    function updateOrInsertTrackedTable($conn, $studentId, $schoolYear, $digit, $val, $completed_day, $completed_month, $completed_hour, $completed_min, $completed_sec) {
        // Use a prepared statement to prevent SQL injection
        $checkQuery = "SELECT 1 FROM questions_tracked 
            WHERE student_id=? AND completed_year=? AND REGEXP_SUBSTR(question_number,'[0-9]+')=?";
        
        $stmt = mysqli_prepare($conn, $checkQuery);
        mysqli_stmt_bind_param($stmt, 'sss', $studentId, $schoolYear, $digit);
        mysqli_stmt_execute($stmt);
        $checkResult = mysqli_stmt_get_result($stmt);
        $existingRows = mysqli_num_rows($checkResult);
    
        if ($existingRows > 0) {
            $trackedQuery = "UPDATE questions_tracked SET 
                question_number='$val',
                completed_day = '$completed_day',
                completed_month = '$completed_month',
                completed_hour = '$completed_hour',
                completed_min = '$completed_min',
                completed_sec = '$completed_sec'
                WHERE student_id='$studentId' AND completed_year='$schoolYear' AND REGEXP_SUBSTR(question_number,'[0-9]+')='$digit'";
            
            $trackedResult = mysqli_query($conn, $trackedQuery);
        } else {
            $query = "INSERT INTO questions_tracked (
                    question_number, 
                    student_id, 
                    completed_year,
                    completed_day,
                    completed_month,
                    completed_hour,
                    ccompleted_min,
                    completed_sec
                ) 
                VALUES (
                    '$val',
                    '$studentId',
                    '$schoolYear',
                    '$completed_day',
                    '$completed_month',
                    '$completed_hour',
                    '$completed_min',
                    '$completed_sec'
                )";
            
            $trackedResult = mysqli_query($conn, $query);
        }
    
        return $trackedResult;
    }

    foreach ($labels as $key => $val) {

        preg_match('/(\d+)/', $val, $matches);
        $digit = $matches[0];

        $completedResult = updateOrInsertCompletedTable($conn, $studentId, $schoolYear, $digit, $val, $timestamp, $classPeriod, $completed_day, $completed_month, $completed_hour, $completed_min, $completed_sec);        
        $trackedResult = updateOrInsertTrackedTable($conn, $studentId, $schoolYear, $digit, $val, $completed_day, $completed_month, $completed_hour, $completed_min, $completed_sec);
    
        if (!$completedResult || !$trackedResult) {
            echo "Error updating or inserting records<br/>";
        }

        // create the weight table from the select labels
        $query = "SELECT weight FROM `weights` WHERE question_number = '" . $val . "'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            if ($row) {
                $weights[] = $row['weight'];
            } else {
                echo "No result for label: " . $val;
            }

        } else {
            echo "Error reading table: " . mysqli_error($conn);
        }
     
    }

    // close the connection
    mysqli_close($conn);

    // get the number of times each digit (1-7) occurs
    $occurrences = array_count_values($weights);

    // get the total sum of occurrences. should total to 28
    $sum = array_sum(array_values($occurrences));
  
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learning Style Results Page</title>
    <link href="./css/results.css" rel="stylesheet"></link>
</head>
<body>
    <h2>Learning Style Results Page</h2>
    <header>
        Student Id: <?php echo $studentId ?>
        &nbsp;&nbsp;
        Student Name: <?php echo $firstName." ".$lastName ?>
        &nbsp;&nbsp;
        Class Period: <?php echo $classPeriod ?>
        &nbsp;&nbsp;
        School Year: <?php echo $schoolYear ?>
    </header>
    <table id="resultsTable">
        <thead>
            <tr>
                <th colspan="9" id="header-label">Total Count of Numbers Selected</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td rowspan="2" class="total-label">Total Each #1-7</td>
                <td id="label">1</td>
                <td id="label">2</td>
                <td id="label">3</td>
                <td id="label">4</td>
                <td id="label">5</td>
                <td id="label">6</td>
                <td id="label">7</td>
                <td id="grand-total-label">Grand Total</td>
            </tr>
            <tr id="dataRow">
                <td id="one" class="data"><?PHP echo isset($occurrences[1])   ? $occurrences[1] : 0; ?></td>
                <td id="two" class="data"><?PHP echo isset($occurrences[2])   ? $occurrences[2] : 0; ?></td>
                <td id="three" class="data"><?PHP echo isset($occurrences[3]) ? $occurrences[3] : 0 ;?></td>
                <td id="four" class="data"><?PHP echo  isset($occurrences[4]) ? $occurrences[4] : 0; ?></td>
                <td id="five" class="data"><?PHP echo  isset($occurrences[5]) ? $occurrences[5] : 0; ?></td>
                <td id="six" class="data"><?PHP echo  isset($occurrences[6])  ? $occurrences[6] : 0; ?></td>
                <td id="seven" class="data"><?PHP echo isset($occurrences[7]) ? $occurrences[7] : 0; ?></td>
                <td id="grandTotal" class="grandTotalData"><?PHP echo $sum ?></td>
            </tr>

        </tbody>
        <tfoot>
            <tr>
                <td colspan="9" id="footer-label">
                    There are no more than 8 for any of ther numbers above 1-7<br/>
                    Your <u>grand total should be 28</u> for the #s 1-7 that was selected.
                </td>
            </tr>
        </tfoot>
    </table>

</body>
</html>