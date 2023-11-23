<!DOCTYPE html>
<?PHP
    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include("php/db.php"); // make a connection to the database

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $studentId = $_POST['studentId'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $classPeriod = $_POST['classPeriod'];
    $labels = explode(',',$_POST['selectedItems']);

    $allQuery = "SELECT label, weight FROM Weights";
    $allResult = mysqli_query($conn, $allQuery);

    $weights = [];
    $bins = [];
    $sum = 0;

    foreach ($labels as $key => $val) {
        $query = "SELECT weight FROM `Weights` WHERE label = '" . $val . "'";
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
    $occurrences = array_count_values($weights);
    $sum = array_sum(array_values($occurrences));
          
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learning Style Results Page</title>
    <link href="./css/results.css" rel="stylesheet"></style>
</head>
<body>
    <h2>Learning Style Results Page</h2>
    <header>
        Student Id: <?PHP echo $studentId ?>
        &nbsp;&nbsp;
        Student Name: <?PHP echo $firstName." ".$lastName ?>
        &nbsp;&nbsp;
        Class Period: <?PHP echo $classPeriod ?>
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
                <td id="one" class="data"><?PHP echo $occurrences[1];  ?></td>
                <td id="two" class="data"><?PHP echo $occurrences[2];  ?></td>
                <td id="three" class="data"><?PHP echo $occurrences[3];?></td>
                <td id="four" class="data"><?PHP echo $occurrences[4]; ?></td>
                <td id="five" class="data"><?PHP echo $occurrences[5]; ?></td>
                <td id="six" class="data"><?PHP echo $occurrences[6];  ?></td>
                <td id="seven" class="data"><?PHP echo $occurrences[7]; ?></td>
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