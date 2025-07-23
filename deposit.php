<?php
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $accountNumber = $_POST["depositAccountNumber"];
    $depositAmount = floatval($_POST["depositAmount"]); // Convert to a float

    // You should perform validation on the input data and handle potential errors.

    // Example: Connect to a database (You need to configure your database settings)
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $dbName = "bnmdb";

    // Create a database connection
    $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch the existing 'deposit' and 'newbal' from the database
    list($existingDeposit, $existingNewBal) = fetchDepositAndNewBalance($conn, $accountNumber);

    if ($existingDeposit !== false && $existingNewBal !== false) {
        // Calculate the new 'deposit' and 'newbal' by adding the deposit to the existing values
        $newDeposit = $existingDeposit + $depositAmount;
        $newBalance = $existingNewBal + $depositAmount;

        // Update the 'deposit' and 'newbal' columns in the database
        $sqlUpdateDeposit = "UPDATE accounts SET deposit = ?, newbal = ? WHERE accnum = ?";
        $stmtUpdateDeposit = $conn->prepare($sqlUpdateDeposit);
        $stmtUpdateDeposit->bind_param("dds", $newDeposit, $newBalance, $accountNumber);

        // Execute the SQL statement to update 'deposit' and 'newbal'
        if ($stmtUpdateDeposit->execute()) {
            // 'deposit' and 'newbal' updated successfully
            echo "Deposit of $" . $depositAmount . " was successful.";
            echo "<br>";
            echo "Total deposit: $" . $newDeposit;
            echo "<br>";
            echo "New balance (newbal): $" . $newBalance;
            echo "<br>";
            echo "'deposit' and 'newbal' updated.";
        } else {
            // Error occurred while updating 'deposit' and 'newbal'
            echo "Error updating 'deposit' and 'newbal': " . $stmtUpdateDeposit->error;
        }

        // Close the prepared statement for updating 'deposit' and 'newbal'
        $stmtUpdateDeposit->close();
    } else {
        echo "The account you wish to deposit to, does not exist. Please check again. ";
    }

    // Close the database connection
    $conn->close();
} else {
    // Handle cases where the form hasn't been submitted
    echo "Form not submitted.";
}

// Function to fetch the existing 'deposit' and 'newbal'
function fetchDepositAndNewBalance($conn, $accountNumber) {
    $sql = "SELECT deposit, newbal FROM accounts WHERE accnum = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $accountNumber);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            return array($row["deposit"], $row["newbal"]);
        }
    }
    return array(false, false);
}