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

// Initialize tables array
$tables = array('teachers', 'students', 'schools', 'weights', 'images', 'questions_completed');
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
        <header id="header" class="header-container">
            <h2 id='title'>Report Builder</h2>
            <a href='../logoff.php' class='button-like-link'>Logout</a>
        </header>
        <?php include('sidebar.html'); ?>
        <div id='main-section'>
            <form action="" method="POST" id="execute-sql-form">
                <div id='table-columns'>
                    <table>
                        <tr>
                            <?php
                            // Create the dropdowns for tables
                            foreach ($tables as $table) {
                                echo "<td class='table-names'><label for='$table'>" . ucwords(str_replace('_', ' ', $table)) . "</label></td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <?php
                            // Create the dropdowns for columns
                            foreach ($tables as $table) {
                                echo "<td class='td-select'><select class='option-select' name='{$table}_column'>";
                                // Fetch columns for each table
                                $tableColumns = getTableColumns($table, $conn);
                                // Create options for each column
                                foreach ($tableColumns as $column) {
                                    echo "<option value='$column'>$column</option>";
                                }
                                echo "</select></td>";
                            }
                            ?>
                        </tr>
                    </table>
                </div>

                <div id="sql-container">
                    <label class="sql-label" for="sql-input">Enter SQL Code:</label>
                    <textarea id="sql-input" name="sql_code" rows="5" cols="40"></textarea>
                    <input type="hidden" name="sql_code_hidden" id="sql-code-hidden" value="">
                    <input class='execute-sql-button' type="submit" value="Execute SQL">
                    <input class='clear-sql-button' type="submit" value="Clear SQL" onclick="clearSqlBox()">
                </div>
            </form>

            <?php
            // Check if SQL code is submitted and not empty
            if (isset($_POST['sql_code_hidden']) && !empty($_POST['sql_code_hidden'])) {
                // Get the submitted SQL code
                $sqlCode = $_POST['sql_code_hidden'];

                // Get the table name from the SQL code
                preg_match('/FROM\s+(\w+)/i', $sqlCode, $matches);
                $tableName = isset($matches[1]) ? $matches[1] : '';

                try {
                    // Fetch columns for the determined table
                    $tableColumns = getTableColumns($tableName, $conn);

                    // Execute the SQL code
                    $result = mysqli_query($conn, $sqlCode);

                    // Display the result table if query is valid
                    if ($result) {
                        echo "<p>SQL Execution Successful</p>";

                        // Fetch column names from the result set
                        $columnNames = array_keys(mysqli_fetch_assoc($result));

                        // Display the result table
                        echo "<table id='record-list-table'>";
                        // Display column headers
                        foreach ($columnNames as $column) {
                            echo "<th class='record-list-header'>$column</th>";
                        }

                        // Reset the result set pointer
                        mysqli_data_seek($result, 0);

                        // Display result rows
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr id='record_row'>";
                            foreach ($row as $value) {
                                echo "<td>$value</td>";
                            }
                            echo "</tr>";
                        }
                        echo "</table>";

                        // Free the result set
                        mysqli_free_result($result);
                    } else {
                        echo "<p>SQL Execution Failed: " . mysqli_error($conn) . "</p>";
                    }
                } catch (Exception $e) {
                    echo "<p>Error: " . $e->getMessage() . "</p>";
                }
            }
            ?>
        </div>
        <div id="footer"><?php include_once("../footer.php"); ?></div>
    </div>

    <script>
        // Add this script to handle clearing the SQL input box
        function clearSqlBox() {
            document.getElementById('sql-input').value = '';
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('execute-sql-form').addEventListener('submit', function (event) {
                event.preventDefault(); // Prevent the default form submission

                // Get the SQL code from the textarea
                var sqlCode = document.getElementById('sql-input').value;

                // Set the value of the hidden input field
                document.getElementById('sql-code-hidden').value = sqlCode;

                // Clear the SQL input box after submission
                // Comment out the next line if you want to keep the content
                document.getElementById('sql-input').value = '';

                // Submit the form
                this.submit();
            });
        });
    </script>
</body>

</html>
