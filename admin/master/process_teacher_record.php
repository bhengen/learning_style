<!DOCTYPE html>
<?php
    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../../php/db.php');

    $teacher_record = $_POST;

    $command = $_POST['command'];
    
    if (strtolower($command) === "update") {
        include('update_teacher_record.php');
     } else if (strtolower($command) === "delete") {
        include("delete_teacher_record.php");
    } else {
        echo "Invalid commnand";
        die;
    }
    
?>
