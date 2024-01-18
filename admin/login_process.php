<?php
    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../php/db.php');

    $teacherId = mysqli_real_escape_string($conn, $_POST['teacherId']);
    $first_name = mysqli_real_escape_string($conn, $_POST['teacherFirstName']);
    $last_name = mysqli_real_escape_string($conn, $_POST['teacherLastName']);

    $query = "SELECT * FROM teachers 
        WHERE teacher_id = '$teacherId' AND
            first_name = '$first_name' AND
            last_name = '$last_name';";

    $result = mysqli_query($conn, $query);
    mysqli_close($conn);

    if (!$result) {
        echo "Error reading from teacher table: " . mysqli_error($conn);
        exit;
    }

    // Check if any rows were returned
    if (mysqli_num_rows($result) > 0) {
        $teacherData = mysqli_fetch_assoc($result);
        $role = $teacherData['role'];

        if ($role === "admin" ) {
            $_SESSION['page'] = 'admin';
            header('Location: master/admin_template.php');
            exit;
        } elseif ($role === 'teacher') {
            $_SESSION['page'] = 'teacher';
            header('Location: teacher/teacher_template.php'); // Change this to the actual teacher page
            exit;
        } else {
            echo "Invalid role";
            die;
        }
    } else {
        echo "Invalid credentials";
        // You may want to redirect back to the login page with an error message
        $_SESSION['error'] = "Invalid credentials";
        header('Location: admin_index.php');
        exit;
    }

?>
