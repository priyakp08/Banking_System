<?php
// Database credentials
$hostname = 'localhost';
$username = 'root';  // Replace with your actual MySQL username
$password = '';  // Replace with your actual MySQL password
$database = 'bnmdb'; // Replace with your actual database name

try {
    // Create a new PDO instance
    $db = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);

    // Set the PDO error mode to exception
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query to select records from the 'accounts' table
    $sql = "SELECT * FROM accounts";

    // Execute the query
    $stmt = $db->query($sql);

    // Fetch and display the results
    echo "<h2>Accounts</h2>";
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
    
    echo "</table>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the database connection
$db = null;
?>
