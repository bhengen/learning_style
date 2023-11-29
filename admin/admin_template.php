<?PHP

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../php/db.php');
    
    $page = $_SESSION['page'];
    echo $page;

    echo "
        <div>
            <p>this is the main body of the admin page</p>
        </div>
    ";
?>