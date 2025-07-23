<?php
// Database credentials
$hostname = 'localhost';
$username = 'root';  // Replace with your actual MySQL username
$password = '';  // Replace with your actual MySQL password
$database = 'bnmdb'; // Replace with your actual database name

if (isset($_POST["searchAccount"])) {
    $searchTerm = $_POST["searchAccountNumber"]; // Retrieve the search term from the form

    try {
        // Create a new PDO instance
        $db = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);

        // Set the PDO error mode to exception
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL query to select records from the 'accounts' table based on the search term
        $sql = "SELECT * FROM accounts WHERE accnum = ? OR accname LIKE ?";
        $stmt = $db->prepare($sql);

        // Bind the search term to the query
        $stmt->execute([$searchTerm, "%$searchTerm"]);

        // Fetch and display the results
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "Account Number: " . $row['accnum'] . "<br>";
            echo "Account Name: " . $row['accname'] . "<br>";
            echo "Initial Balance: $" . $row['initialbal'] . "<br>";
            echo "Deposit: $" . $row['deposit'] . "<br>";
            echo "Withdraw: $" . $row['withdraw'] . "<br>";
            echo "New Balance: $" . $row['newbal'] . "<br><br>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} elseif (isset($_POST["accountNumber"]) && isset($_POST["accountName"]) && isset($_POST["initialBalance"])) {
    // Handle the "Add Account" form submission
    $accountNumber = $_POST["accountNumber"];
    $accountName = $_POST["accountName"];
    $initialBalance = floatval($_POST["initialBalance"]);
    
    try {
        // Create a new PDO instance
        $db = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);

        // Set the PDO error mode to exception
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL query to insert a new account into the 'accounts' table
        $sql = "INSERT INTO accounts (accnum, accname, initialbal, deposit, withdraw, newbal) VALUES (?, ?, ?, 0, 0, ?)";
        $stmt = $db->prepare($sql);

        // Calculate the 'newbal' column based on the initial balance
        $newBalance = $initialBalance;

        // Bind the parameters to the query
        $stmt->execute([$accountNumber, $accountName, $initialBalance, $newBalance]);

        echo "Account added successfully.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    // Handle cases where the form hasn't been submitted
    echo "Form not submitted.";
}
?>
