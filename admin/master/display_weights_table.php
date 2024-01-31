<!DOCTYPE html>
<?php

      // error_reporting(E_ALL);
      ini_set('display_errors', 1);
      include('../../php/db.php');
      
      $sort = isset($_GET['sort']) ? $_GET['sort'] : 'weight_id'; // Default sorting by weight_id
      $order = isset($_GET['order']) ? $_GET['order'] : 'asc'; // Default order ascending
      
      // Filtering
      $filter = "";
      $category = isset($_POST["category"]) ? $_POST['category'] : '';
      $search_term = isset($_POST['search']) ? $_POST['search'] : '';
  
      $reset_flag = isset($_POST['reset-flag']);
      
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
        <header id="header" class="header-container">
            <h2 id='title'>Weights Table</h2> <br/>
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

                <select name='category' id="option-search-term">
                    <option value="question_number">Question Number</option>
                    <option value="weight">Weight</option>

                </select>
                <!-- Hidden input for reset flag -->
                <input type="hidden" name="reset" id="reset-flag" value="0">
                
                <input type="submit" value="Reset Filter" id="button-reset-filter">
                <input type="submit" value="Filter" id="button-filter">

            </form>


            <table id='record-list-table'>
                <th class='record-list-header'>
                    <a id='sort-link' href='?sort=weight_id&order=desc'> << </a>
                        Question Number
                    <a id='sort-link' href='?sort=weight_id&order=asc'> >> </a>
                </th>
                <th class='record-list-header'>
                    <a id='sort-link' href='?sort=weight&order=desc'> << </a>
                        Weight
                    <a id='sort-link' href='?sort=weight&order=asc'> >> </a>
                </th>
                <?php
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr id='record_row'>";
                        echo "
                            <td class='record-list-data'>
                                <a href='edit_weights_table.php?question_number=$row[question_number]' id='tdata'>$row[question_number]</a>
                            </td>
                            <td class='record-list-data'>$row[weight]</td>
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