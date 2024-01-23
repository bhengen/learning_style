<!DOCTYPE html>
<?php

      // error_reporting(E_ALL);
      ini_set('display_errors', 1);
      include('../../php/db.php');
      
      $sort = isset($_GET['sort']) ? $_GET['sort'] : 'weight_id'; // Default sorting by student_id
      $order = isset($_GET['order']) ? $_GET['order'] : 'asc'; // Default order ascending
      
      // Filtering
      $filter = "";
      $category = isset($_POST["category"]) ? $_POST['category'] : '';
      $search_term = isset($_POST['search']) ? $_POST['search'] : '';
  
      $reset_flag = isset($_POST['reset_flag']);
      
      if ( $reset_flag) {
          $filter = " WHERE 1";
      } else {
          if (!empty($search_term)) {
              $filter = " WHERE $category = '$search_term'";
          }      
      } 

    $query = "SELECT * from weights $filter ORDER BY $sort $order";    
    $result = mysqli_query($conn, $query);
?>
<html lang="en"> 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Weights Table</title>
        <link rel="stylesheet" href="../../css/admin.css">
    </head>
<body>
    
    <div id="container">
        <header id="header" class="header_container">
            <h2 id='title'>Weights Table</h2> <br/>
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
                    <option value="question_number">Question Number</option>
                    <option value="weight">Weight</option>

                </select>
                <!-- Hidden input for reset flag -->
                <input type="hidden" name="reset" id="reset_flag" value="0">
                
                <input type="submit" value="Reset Filter" id="button_reset_filter">
                <input type="submit" value="Filter" id="button_filter">

            </form>


            <table id='record_list_table'>
                <th class='record_list_header'>
                    <a id='sort-link' href='?sort=weight_id&order=desc'> << </a>
                        Question Number
                    <a id='sort-link' href='?sort=weight_id&order=asc'> >> </a>
                </th>
                <th class='record_list_header'>
                    <a id='sort-link' href='?sort=weight&order=desc'> << </a>
                        Weight
                    <a id='sort-link' href='?sort=weight&order=asc'> >> </a>
                </th>
                <?php
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr id='record_row'>";
                        echo "
                            <td class='record_list_data'>
                                <a href='edit_weights_table.php?question_number=$row[question_number]' id='tdata'>$row[question_number]</a>
                            </td>
                            <td class='record_list_data'>$row[weight]</td>
                        ";
                        echo "</tr>";
                    };
                ?>
        </table>
        </div>
    </div>
    <script>
        document.getElementById('button_reset_filter').addEventListener('click', function() {
            // Prevent the default form submission behavior
            event.preventDefault();
            
            // Set the reset flag to indicate that reset button was clicked
            document.getElementById('reset_flag').value = "1";
             
            // Reset the search input value
            document.getElementById('text_search_category').value = '';

            // Reset the selected option in the dropdown
            let dropdown = document.getElementById('option_search_term');
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