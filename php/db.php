<?php
$servername = "az1-ss32.a2hosting.com";
$username = "bhengena_learning";
$password = "learn";
$dbname = "bhengena_quiz_results";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
