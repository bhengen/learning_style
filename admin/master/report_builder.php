<!DOCTYPE html>
<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include('../../php/db.php');
    
    // Function to get column names from a table
    function getTableColumns($tableName, $conn)
    {
        $columns = array();

        // Fetch column names from the table
        $query = "SHOW COLUMNS FROM $tableName";
        $result = mysqli_query($conn, $query);

        // Check if the query was successful
        if ($result) {
            // Fetch column names into an array
            while ($row = mysqli_fetch_assoc($result)) {
                $columns[] = $row['Field'];
            }

            // Free the result set
            mysqli_free_result($result);
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }

        return $columns;
    }

    // create tables array
    $tables = array('teachers', 'students', 'schools', 'weights', 'images');

    // Fetch columns for all tables
    $tableColumns = array();
    foreach ($tables as $table) {
        $tableColumns[$table] = getTableColumns($table, $conn);
    }

    // Close the connection
    mysqli_close($conn);
    
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Report Builder</title>
        <link rel="stylesheet" href="../../css/admin.css">
    </head>

    <body>
        <div id="container">
            <header id="header" class="header_container">
                <h2 id='title'>Report Builder</h2> 
                <a href='../logoff.php' class='button-like-link'>Logout</a>
            </header>
            <?php include('sidebar.html'); ?>
            <div id='main_section'>
                <table>
                    <tr>
                        <?php
                            foreach ($tables as $table) {
                                echo "<td><label for='$table'>".ucwords($table).':'."</label></td>";
                            }
                        ?>
                    <tr>
                        <?php
                            // create the section/option tags for all tables
                            foreach ($tables as $table) {
                                echo "<td width='250px'><select id='option-select' name='$table'>";
                                          
                                // Create options for each column
                                foreach ($tableColumns[$table] as $column) {
                                    echo "<option value='$column'>$column</option>";
                                }
                                echo "</select></td>";
                            }
                        ?>
                    </tr>
                </table>
                 <table id='record_list_table'>
                    <th class='record_list_header'>Name</th>
                    <th class='record_list_header'>City</th>
                    <th class='record_list_header'>State</th>
                    <th class='record_list_header'>Postal Code</th>
                    <tr id='record_row'>
                        <td class='add_list_data'></td>
                        <td class='add_list_data'></td>
                        <td class='add_list_data'></td>
                        <td class='add_list_data'></td>
                    </tr>
                </table>
        </div>
        <div id="footer"><?php include_once("../footer.php"); ?></div>
    </body>
</html>