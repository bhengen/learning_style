<!DOCTYPE html>
<?php

    // error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../../php/db.php');
    
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'qc.student_id'; // Default sorting by student_id
    $order = isset($_GET['order']) ? $_GET['order'] : 'asc'; // Default order ascending
    
    // Filtering
    $filter = "";
    $category = isset($_POST["category"]) ? $_POST['category'] : '';
    $search_term = isset($_POST['search']) ? $_POST['search'] : '';

    $reset_flag = isset($_POST['reset_flag']);
    
    if($category == "student_id" || $category == "first_name" || $category == "last_name") {
        $category = "s.".$category;
    } else {
        $category = "qc.".$category;
    }

    if ( $reset_flag) {
        $filter = " WHERE 1";
    } else {
        if (!empty($search_term)) {
            $filter = " WHERE $category = '$search_term'";
        }      
    } 

    $query = "SELECT qc.student_id, first_name, last_name, qc.question_number, qc.class_period, qc.completed_year 
                FROM questions_completed AS qc
                LEFT JOIN students AS s ON qc.student_id = s.student_id
                $filter
                ORDER BY $sort $order
    ";
    $result = mysqli_query($conn, $query);
?>
<html lang="en"> 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Assessment Record Listing</title>
        <link rel="stylesheet" href="../../css/admin.css">
    </head>
<body>
    
    <div id="container">
        <header id="header" class="header-container">
            <h2 id='title'>Assessment Record List </h2> <br/>
            <a href=../logoff.php class='button-like-link'>Logout</a>
        </header>
        <?php include('sidebar.html'); ?>

        <div id='main-section'>
                    
            <!-- Search Form -->
            <form action="" method="POST" id="search-form">
                <!-- First Row -->
                <label for="search" id="label-search-term">Filter Term:</label>
                <label for="category" id="label-search-category">Filter By:</label>

                <!-- Second Row -->
                <input type="text" name="search" id="text-search-category">

                <select name='category' id="option_search_term">
                    <option value="student_id">Student Id</option>
                    <option value="first_name">First Name</option>
                    <option value="last_name">Last Name</option>
                    <option value="question_number">Question Number</option>
                    <option value="class_period">Class Period</option>    
                    <option value="completed_year">Completed Year</option>
                </select>
                <!-- Hidden input for reset flag -->
                <input type="hidden" name="reset" id="reset_flag" value="0">
                
                <input type="submit" value="Reset Filter" id="button_reset_filter">
                <input type="submit" value="Filter" id="button_filter">

            </form>


            <table id='record-list-table'>
                <th class='record-list-header'>
                    <a id='sort-link' href='?sort=student_id&order=desc'> << </a>
                        Student Id
                    <a id='sort-link' href='?sort=student_id&order=asc'> >> </a>
                </th>
                <th class='record-list-header'>
                    <a id='sort-link' href='?sort=first_name&order=desc'> << </a>
                        First Name
                    <a id='sort-link' href='?sort=first_name&order=asc'> >> </a>
                </th>
                <th class='record-list-header'>
                    <a id='sort-link' href='?sort=last_name&order=desc'> << </a>
                        Last Name
                    <a id='sort-link' href='?sort=last_name&order=asc'> >> </a>
                </th>
                <th class='record-list-header'>
                    <a id='sort-link' href='?sort=question_number&order=desc'> << </a>
                        Question Number
                    <a id='sort-link' href='?sort=question_number&question_number=asc'> >> </a>
                </th>
                <th class='record-list-header'>
                    <a id='sort-link' href='?sort=class_period&order=desc'> << </a>
                        Class Period
                    <a id='sort-link' href='?sort=class_period&order=asc'> >> </a>
                </th>
                <th class='record-list-header'>
                    <a id='sort-link' href='?sort=completed_year&order=desc'> << </a>
                        Completed Year
                    <a id='sort-link' href='?sort=completed_year&order=asc'> >> </a>
                </th>
                <?php
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr id='record_row'>";
                        echo "
                            <td class='record_list_data'>$row[student_id]</a></td>
                            <td class='record_list_data'>$row[first_name]</td>
                            <td class='record_list_data'>$row[last_name]</td>
                            <td class='record_list_data'>$row[question_number]</td>
                            <td class='record_list_data'>$row[class_period]</td>
                            <td class='record_list_data'>$row[completed_year]</td>
                        ";
                        echo "</tr>";
                    };
                ?>
        </table>
        </div>
    </div>
    <script>
        document.getElementById('button-reset-filter').addEventListener('click', function() {
            // Prevent the default form submission behavior
            event.preventDefault();
            
            // Set the reset flag to indicate that reset button was clicked
            document.getElementById('reset-flag').value = "1";
             
            // Reset the search input value
            document.getElementById('text-search-category').value = '';

            // Reset the selected option in the dropdown
            let dropdown = document.getElementById('option-search_term');
            dropdown.selectedIndex = 0;
            
            // Remove sorting parameters from the current URL
            let currentURL = window.location.href;
            let baseURL = currentURL.split('?')[0]; // Get the URL without query parameters
            window.location.href = baseURL; // Set the page location to the URL without sorting parameters
        });
    </script>
</body>
</html>

<?php mysqli_close($conn); ?>