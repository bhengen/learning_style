<?php
    // logout.php

    session_start();  // Start the session

    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page or any other desired page
    header("Location: admin_index.php");
    exit();
?>
