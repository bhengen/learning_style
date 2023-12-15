<!DOCTYPE html>
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
include('../php/db.php');


$teacher_id = $_GET['tid'];

$query = "SELECT * FROM teachers WHERE teacher_id=$teacher_id";
$result = mysqli_query($conn, $query);

$row = mysqli_fetch_assoc($result);

$first_name = $row['first_name'];
$last_name = $row['last_name'];
$role = $row['role'];


?>
<html>
<body>
    <form>
        <label>Teacher Id</label>
        <input type="text" name="teacher_id" value="<?php echo $teacher_id; ?>" >
        <label>First  Name</label>
        <input type="text" name="first_name" value="<?php echo $first_name; ?> "">
        <br/>
        <label>Last  Name</label>
        <input type="text" name="last_name" value = "<?php echo $first_name; ?> "">
        <br/>
        <label>Role</label>
        <input type="text" name="role" value= "<?php echo $role; ?> >

        <button name='submit'>Update  Record</button>

    </form>
</body>
</html>