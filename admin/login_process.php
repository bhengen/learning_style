<?php
    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../php/db.php');
  
    $teacherId = $_POST['teacherId'];
    $first_name = $_POST['teacherFirstName'];
    $last_name = $_POST['teacherLastName'];

    
    $query = "SELECT * from teachers where teacher_id='$teacherId';";
    $result = mysqli_query($conn, $query);
    $teacherData = mysqli_fetch_assoc($result);
    $role = $teacherData['role'];
    
    
    if (
        
        
        strtolower($teacherData['first_name']) !==  strtolower($first_name)) {
        echo "Invalid entry, please try again";
        die;
    }

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