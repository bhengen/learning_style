<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Report</title>
    <link href="../css/generate_report.css" rel="stylesheet"></link>

    </style>
</head>
<body>

<?php
// Connect to the Database
include('../php/db.php');

// Execute SQL Query
$query = "SELECT s.student_id, w.weight, COUNT(qc.question_number) AS occurrences
          FROM (SELECT DISTINCT student_id FROM questions_completed) s
          CROSS JOIN (SELECT DISTINCT question_number, weight FROM weights) w
          LEFT JOIN questions_completed qc ON s.student_id = qc.student_id AND w.question_number = qc.question_number
          GROUP BY s.student_id, w.weight
          ORDER BY s.student_id, w.weight";

$result = $conn->query($query);

// Fetch data into an associative array
$data = array();
while ($row = $result->fetch_assoc()) {
    $data[$row['student_id']][$row['weight']] = $row['occurrences'];
}

// Close Database Connection
$conn->close();
?>

<!-- Display the table on the webpage -->
<div class="container">
    <table>
        <tr>
            <th class="studentId">Student ID</th>
            <th class="weights">1</th>
            <th class="weights">2</th>
            <th class="weights">3</th>
            <th class="weights">4</th>
            <th class="weights">5</th>
            <th class="weights">6</th>
            <th class="weights">7</th>
        </tr>

        <?php foreach ($data as $studentId => $weights): ?>
            <tr>
                <td><?php echo $studentId; ?></td>
                <?php for ($i = 1; $i <= 7; $i++): ?>
                    <td><?php echo isset($weights[$i]) ? $weights[$i] : 0; ?></td>
                <?php endfor; ?>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<!-- Add a submit button -->
<form action="your_script_to_process_submit.php" method="post">
    <input type="submit" value="Submit">
</form>

</body>
</html>
