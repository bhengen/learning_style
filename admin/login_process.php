<?php
    session_start();
    
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../php/db.php');
  
    $teacherId = $_POST['teacherId'];
 
    $query = "SELECT role from teachers where teacher_id='$teacherId';";
    $result = mysqli_query($conn, $query);
    $role = mysqli_fetch_column($result);
  
    if ($role === "admin") {
        $_SESSION['page'] = 'admin';
    } else if ($role === 'teacher') {
        $_SESSION['page'] = 'teacher';
    } else{
        echo "Invalid role";
        die;
    }

    header('Location: admin_index.php');

    mysqli_close($conn);
  

?>