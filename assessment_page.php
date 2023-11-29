<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=0">
    <link rel="stylesheet" href="css/gallery.css">
    <title>Student Assessment Form</title>
</head>
<body>
<header>
    <h2>Learn Style Assessment Page</h2>
    <h3>What is your learning style?</h3>
    <p>From each of the images below, pick which option (A or B) you most closely identify with.</p>
    <p>Your score will automatically be tallied as you select the corresponding option.</p>
    <br/>
    <div class="studentInformation">
        <?PHP
            echo "<p id='studentId'>Student Id: " . $_POST['studentId'] . "</p>".
                 "<p>First Name: " . $_POST['firstName'] . "</p> ".
                 "<p>Last Name: " . $_POST['lastName'] . "</p> ".
                 "<p>Class Period: " . $_POST['classPeriod'] . "</p>";
        ?>
    </div>
</header>
<main>
    <div class="image-gallery" id="imageGallery"></div>
    <form id="assessmentForm" action="process.php" method="post">
        <!-- Hidden input fields for student information -->
        <input type="hidden" name="studentId" value="<?php echo $_POST['studentId']; ?>">
        <input type="hidden" name="firstName" value="<?php echo $_POST['firstName']; ?>">
        <input type="hidden" name="lastName" value="<?php echo $_POST['lastName']; ?>">
        <input type="hidden" name="classPeriod" value="<?php echo $_POST['classPeriod']; ?>">
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
