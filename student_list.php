<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/student_list.css" rel="stylesheet">
    <title>Student Data Processing Form</title>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this student?");
        }
</script>

</head>
<body>
<h1>Student Modification Form</h1>
    <div class="container">
        <?php include('php/students.php'); ?>
    </div>
</body>
</html>
