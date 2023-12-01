<?PHP

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../php/db.php');

    $query = "SELECT * from students ORDER BY student_id";


?>