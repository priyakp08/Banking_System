<?php
// Database credentials
$hostname = 'localhost';
$username = 'root';  // Replace with your actual MySQL username
$password = '';  // Replace with your actual MySQL password
$database = 'bnmdb'; // Replace with your actual database name

// Check if the account number to delete is provided in the POST request
if (isset($_POST['deleteAccountNumber'])) {
    $accountNumberToDelete = $_POST['deleteAccountNumber'];

    try {
        // Create a new PDO instance
        $db = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);

        // Set the PDO error mode to exception
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL query to delete a record from the 'accounts' table based on the account number
        $sql = "DELETE FROM accounts WHERE accnum = :accountNumber";

        // Prepare the query
        $stmt = $db->prepare($sql);

        // Bind the account number from the POST data to the prepared statement
        $stmt->bindParam(':accountNumber', $accountNumberToDelete, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Check the number of affected rows
        $rowCount = $stmt->rowCount();

        if ($rowCount > 0) {
            echo "Account with Account Number $accountNumberToDelete has been deleted.";
        } else {
            echo "Account does not exist.";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close the database connection
    $db = null;
} else {
    // If account number is not provided in the POST request
    echo "Please provide an account number to delete.";
}
?>