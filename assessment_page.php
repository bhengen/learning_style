<!DOCTYPE html>
<?php 

    session_start();

    if (empty($_POST)) {
        echo '<script>window.location.href="index.php"</script>';
        exit;
    }

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Check if the timestamp is already stored in the session
    if (!isset($_SESSION['timestamp'])) {
        // If not, set the timestamp
        $_SESSION['timestamp'] = date("YmdHis");
    }
    $timestamp = date("YmdHis");
    list($year, $month, $day, $hour, $minute, $second) = sscanf(date("YmdHis"), "%4s%2s%2s%2s%2s%2s");

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0">
    <link rel="stylesheet" href="css/gallery.css">
    <title>Student Assessment Form</title>
</head>
<body>
<header>
    <h2>Learn Style Assessment Pages</h2>
    <h3>What is your learning style?</h3>
    <p>From each of the images below, pick which option (A or B) you most closely identify with.</p>
    <p>Your score will automatically be tallied as you select the corresponding option.</p>
    <br/>
    <div class="studentInformation">
        <?php
            echo "<p id='studentId'>Student Id: " . $_POST['studentId'] . "</p>".
                 "<p>First Name: " . $_POST['firstName'] . "</p> ".
                 "<p>Last Name: " . $_POST['lastName'] . "</p> ".
                 "<p>Class Period: " . $_POST['classPeriod'] . "</p>".
                 "<p>School Year: " . $_POST['schoolYear'] ."</p>";
        ?>
    </div>
</header>
<main>
    <div class="image-gallery" id="imageGallery"></div>
    <form id="assessmentForm" action="process.php" method="post">
        <!-- Hidden input fields for student information -->
        <input type="hidden" name="timestamp" value="<?php echo $timestamp; ?> "> 
        <input type="hidden" id="student_id" name="studentId" value="<?php echo $_POST['studentId']; ?>">
        <input type="hidden" name="firstName" value="<?php echo $_POST['firstName']; ?>">
        <input type="hidden" name="lastName" value="<?php echo $_POST['lastName']; ?>">
        <input type="hidden" name="classPeriod" value="<?php echo $_POST['classPeriod']; ?>">
        <input type="hidden" id="completedDay" name="completedDay" value="<?php echo $day; ?>">
        <input type="hidden" id="completedMonth" name="completedMonth" value="<?php echo $month; ?>">
        <input type="hidden" id="schoolYear" name="schoolYear"  value="<?php echo $_POST['schoolYear']; ?>">
        <input type="hidden" id="completedHour" name="completedHour" value="<?php echo $hour; ?>">
        <input type="hidden" id="completedMin" name="completedMin" value="<?php echo $minute; ?>">
        <input type="hidden" id="completedSec" name="completedSec" value="<?php echo $second; ?>">

        <input type="hidden" id="selected_items" name="selectedItems">
        <!-- Submit button -->
        <div class="button-container">
            <button type="button" id="submitButton">Complete</button>
        </div>

    </form>
</main>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="scripts/create_page.js" type="text/javascript"></script>
</body>
</html>
