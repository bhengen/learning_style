<!DOCTYPE html>
<?php

    // error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../../php/db.php');

    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'teacher_id'; // Default sorting by student_id
    $order = isset($_GET['order']) ? $_GET['order'] : 'asc'; // Default order ascending
    
    // Filtering
    $filter = "";
    $category = isset($_POST["category"]) ? $_POST['category'] : '';
    $search_term = isset($_POST['search']) ? $_POST['search'] : '';

    $reset_flag = isset($_POST['reset_flag']);

    if ( $reset_flag) {
        $filter = " Where 1";
    } else {
        if (!empty($search_term)) {
            $filter = " WHERE $category LIKE '%$search_term%'";
        }      
    } 

    $query = "SELECT * FROM teachers $filter ORDER BY $sort $order";
    $result = mysqli_query($conn, $query);
?>
<html lang="en"> 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Teacher Record Listing</title>
        <link rel="stylesheet" href="../../css/admin.css">
    </head>
<body>
    
    <div id="container">
        <header id="header" class="header_container">
            <h2 id='title'>Teacher Record List </h2> <br/>
            <a href=../logoff.php class='button-like-link'>Logout</a>
        </header>
        <?php include('sidebar.html'); ?>

        <div id='main_section'>
                    
            <!-- Search Form -->
            <form action="" method="POST" id="search_form">
                <!-- First Row -->
                <label for="search" id="label_search_term">Filter Term:</label>
                <label for="category" id="label_search_category">Filter By:</label>

                <!-- Second Row -->
                <input type="text" name="search" id="text_search_category">

                <select name='category' id="option_search_term">
                    <option value="teacher_id">Teacher Id</option>
                    <option value="first_name">First Name</option>
                    <option value="last_name">Last Name</option>
                    <option value="role">Role</option>
                    <option value="school_name">School Name</option>    
                    <option value="city">City</option>
                    <option value="state">State</option>
                    <option value="postal_code">Postal Code</option>
                </select>
                <!-- Hidden input for reset flag -->
                <input type="hidden" name="reset" id="reset_flag" value="0">
                
                <input type="submit" value="Reset Filter" id="button_reset_filter">
                <input type="submit" value="Filter" id="button_filter">

            </form>


            <table id='record_list_table'>
                <th class='record_list_header'>
                    <a id='sort-link' href='?sort=teacher_id&order=desc'> << </a>
                        Teacher Id
                    <a id='sort-link' href='?sort=teacher_id&order=asc'> >> </a>
                </th>
                <th class='record_list_header'>
                    <a id='sort-link' href='?sort=first_name&order=desc'> << </a>
                        First Name
                    <a id='sort-link' href='?sort=first_name&order=asc'> >> </a>
                </th>
                <th class='record_list_header'>
                    <a id='sort-link' href='?sort=last_name&order=desc'> << </a>
                        Last Name
                    <a id='sort-link' href='?sort=last_name&order=asc'> >> </a>
                </th>
                <th class='record_list_header'>
                    <a id='sort-link' href='?sort=role&order=desc'> << </a>
                        Role
                    <a id='sort-link' href='?sort=role&order=asc'> >> </a>
                </th>
                <th class='record_list_header'>
                    <a id='sort-link' href='?sort=school_name&order=desc'> << </a>
                        School Name
                    <a id='sort-link' hrtef='?sort=school_name&order=asc'> >> </a>
                </th>
                <th class='record_list_header'>
                    <a id='sort-link' href='?sort=city&order=desc'> << </a>
                        City
                    <a id='sort-link' href='?sort=city&order=asc'> >> </a>
                </th>
                <th class='record_list_header'>
                    <a id='sort-link' href='?sort=state&order=desc'> << </a>
                        State
                    <a id='sort-link' href='?sort=state&order=asc'> >> </a>
                </th>
                <th class='record_list_header'>
                    <a id='sort-link' href='?sort=postal_code&order=desc'> << </a>
                        Postal Code
                    <a id='sort-link' href='?sort=postal_code&order=asc'> >> </a>
                </th>
                <?php
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr id='record_row'>";
                        echo "
                            <td class='record_list_data'>
                                <a href='edit_teacher_record.php?tid=$row[teacher_id]' id='tdata'>$row[teacher_id]</a></td>
                            <td class='record_list_data'>$row[first_name]</td>
                            <td class='record_list_data'>$row[last_name]</td>
                            <td class='record_list_data'>$row[role]</td>
                            <td class='record_list_data'>$row[school_name]</td>
                            <td class='record_list_data'>$row[city]</td>
                            <td class='record_list_data'>$row[state]</td>
                            <td class='record_list_data'>$row[postal_code]</td>
                        ";
                        echo "</tr>";
                    };
                ?>
        </table>
        </div>
    </div>
    <script>
        document.getElementById('button_reset_filter').addEventListener('click', function() {
            // Set the reset flag to indicate that reset button was clicked
            document.getElementById('reset_flag').value = "1";
            
            // Reset the search input value
            document.getElementById('text_search_category').value = '';

            // Reset the selected option in the dropdown
            let dropdown = document.getElementById('option_search_term');
            dropdown.selectedIndex = 0;
        });
    </script>
</body>
</html>

<?php mysqli_close($conn); ?>