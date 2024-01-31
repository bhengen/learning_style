<!DOCTYPE html>
<?php

    // error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../../php/db.php');

    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'student_id'; // Default sorting by student_id
    $order = isset($_GET['order']) ? $_GET['order'] : 'asc'; // default sort ascending order

    // Filtering
    $filter = "";
    $category = isset($_POST["category"]) ? $_POST['category'] : '';
    $search_term = isset($_POST['search']) ? $_POST['search'] : '';

    $reset_flag = isset($_POST['reset_flag']);
    echo $reset_flag;

    if ( $reset_flag) {
        $filter = " Where 1";
    } else {
        if (!empty($search_term)) {
            $filter = " WHERE $category LIKE '%$search_term%'";
        }      
    } 

    $query = "SELECT * FROM students $filter ORDER BY $sort $order";
    $result = mysqli_query($conn, $query);

?>
<html lang="en"> 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Student Record Listing</title>
        <link rel="stylesheet" href="../../css/admin.css">
    </head>
<body>
    
    <div id="container">
        <header id="header" class="header-container">
            <h2 id='title'>Student Record List </h2> 
            <a href='../logoff.php' class='button-like-link'>Logout</a>
        </header>
        <?php  include('sidebar.html'); ?>
        <div id='main-section'>
        
            <!-- Search Form -->
            <form action="" method="POST" id="search-form">
                <!-- First Row -->
                <label for="search" id="label-search-term">Filter Term:</label>
                <label for="category" id="label-search-category">Filter By:</label>

                <!-- Second Row -->
                <input type="text" name="search" id="text-search-category">

                <select name='category' id="option-search-term">
                    <option value="student_id">Student Id</option>
                    <option value="first_name">First Name</option>
                    <option value="last_name">Last Name</option>
                    <option value="class_period">Class Period</option>
                    <option value="school_name">School Name</option>    
                    <option value="city">City</option>
                    <option value="state">State</option>
                    <option value="postal_code">Postal Code</option>
                </select>
                <!-- Hidden input for reset flag -->
                <input type="hidden" name="reset" id="reset-flag" value="0">
                
                <input type="submit" value="Reset Filter" id="button-reset-filter">
                <input type="submit" value="Filter" id="button-filter">

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
                    <a id='sort-link' href='?sort=last_name&order=desc'> << 
                        Last Name
                    <a id='sort-link' href='?sort=last_name&order=asc'> >> </a>
                </th>
                <th class='record-list-header'>
                    <a id='sort-link' href='?sort=class_period&order=desc'> << </a>
                        Class Period
                    <a id='sort-link' href='?sort=class_period&order=asc'> >> </a>
                </th>
                <th class='record-list-header'>
                    <a id='sort-link' href='?sort=school_name&order=desc'> << </a>
                        School Name
                    <a id='sort-link' href='?sort=school_name&order=asc'> >> </a>
                </th>
                <th class='record-list-header'>
                    <a id='sort-link' href='?sort=city&order=desc'> << </a>
                        City
                    <a id='sort-link' href='?sort=city&order=asc'> >> </a>
                </th>
                <th class='record-list-header'>
                    <a id='sort-link' href='?sort=state&order=desc'> << </a>
                        State
                    <a id='sort-link' href='?sort=state&order=asc'> >> </a>
                </th>
                <th class='record-list-header'>
                    <a id='sort-link' href='?sort=postal_code&order=desc'> << </a>
                        Postal Code
                    <a id='sort-link' href='?sort=postal_code&order=asc'> >> </a>
                </th>
                <?php
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr id='record-row'>";
                        echo "
                            <td class='record-list-data'>
                                <a href='edit_student_record.php?student_id=$row[student_id]' id='tdata'>$row[student_id]</a>
                            </td>
                            <td class='record-list-data'>$row[first_name]</td>
                            <td class='record-list-data'>$row[last_name]</td>
                            <td class='record-list-data'>$row[class_period]</td>
                            <td class='record-list-data'>$row[school_name]</td>
                            <td class='record-list-data'>$row[city]</td>
                            <td class='record-list-data'>$row[state]</td>
                            <td class-'record-list-data'>$row[postal_code]</td>
                        ";
                        echo "</tr>";
                    };
                ?>
        </table>
        </div>
        <div id="footer">
                <?php include_once("../footer.php"); ?>
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
            let dropdown = document.getElementById('option-search-term');
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