<?php
// Database credentials
$hostname = 'localhost';
$username = 'root';  // Replace with your actual MySQL username
$password = '';  // Replace with your actual MySQL password
$database = 'bnmdb'; // Replace with your actual database name

// Check if the account name to search is provided in the POST request
if (isset($_POST['searchAccountName'])) {
    $accountNameToSearch = $_POST['searchAccountName']; // Update input field name to 'searchAccountName'

    try {
        // Create a new PDO instance
        $db = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);

        // Set the PDO error mode to exception
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL query to select a record from the 'accounts' table based on the account name
        $sql = "SELECT * FROM accounts WHERE accname = :accountName"; // Search by account name

        // Prepare the query
        $stmt = $db->prepare($sql);

        // Bind the account name from the POST data to the prepared statement
        $stmt->bindParam(':accountName', $accountNameToSearch, PDO::PARAM_STR);

        // Execute the query
        $stmt->execute();

        // Check if any rows were returned
        $rowCount = $stmt->rowCount();

        if ($rowCount > 0) {
            // Fetch and display the result
            echo "<h2>Search Result</h2>";
            echo "<table border='1'>";
            echo "<tr><th>Account Number</th><th>Account Name</th><th>Initial Balance</th><th>Deposit</th><th>Withdraw</th><th>New Balance</th></tr>";

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['accnum'] . "</td>";
                echo "<td>" . $row['accname'] . "</td>";
                echo "<td>$" . $row['initialbal'] . "</td>";
                echo "<td>$" . $row['deposit'] . "</td>";
                echo "<td>$" . $row['withdraw'] . "</td>";
                echo "<td>$" . $row['newbal'] . "</td>";
                echo "</tr>";
            }

            echo "</table";
        } else {
            echo "Account not found";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close the database connection
    $db = null;
} else {
    // If account name is not provided in the POST request
    echo "Please provide an account name to search.";
}
?>
