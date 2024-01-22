<!DOCTYPE html>
<?php
    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    $images_record = $_POST;
 
    $command = $_POST['command'];
    
    if (strtolower($command) === "update") {
        include('update_image_record.php');
     } else if (strtolower($command) === "delete") {
        include("delete_image_record.php");
    } else {
        echo "Invalid commnand";
        die;
    }
    
?>
