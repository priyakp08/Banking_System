
<?php
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $accountNumber = $_POST["withdrawAccountNumber"];
    $withdrawAmount = floatval($_POST["withdrawAmount"]); // Convert to a float

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

    // Check if the account exists and has sufficient balance for withdrawal
    $checkBalanceSQL = "SELECT newbal FROM accounts WHERE accnum = ?";
    $stmt = $conn->prepare($checkBalanceSQL);
    $stmt->bind_param("s", $accountNumber);
    $stmt->execute();
    $stmt->bind_result($newBalance);

    if ($stmt->fetch()) {
        if ($newBalance >= $withdrawAmount) {
            // Withdrawal is allowed
            $stmt->close();

            // Update the 'withdraw' column in the database
            $updateWithdrawSQL = "UPDATE accounts SET withdraw = withdraw + ? WHERE accnum = ?";
            $stmtUpdateWithdraw = $conn->prepare($updateWithdrawSQL);
            $stmtUpdateWithdraw->bind_param("ds", $withdrawAmount, $accountNumber);

            // Execute the SQL statement to update 'withdraw'
            if ($stmtUpdateWithdraw->execute()) {
                // Calculate the new 'newbal' value by subtracting the withdrawn amount from the existing value
                $existingNewBalance = fetchNewBalance($conn, $accountNumber);
                $newNewBalance = $existingNewBalance - $withdrawAmount;

                // Update the 'newbal' column in the database
                $updateNewBalanceSQL = "UPDATE accounts SET newbal = ? WHERE accnum = ?";
                $stmtUpdateNewBalance = $conn->prepare($updateNewBalanceSQL);
                $stmtUpdateNewBalance->bind_param("ds", $newNewBalance, $accountNumber);

                // Execute the SQL statement to update 'newbal'
                if ($stmtUpdateNewBalance->execute()) {
                    // Withdrawal successful
                    echo "Withdrawal of $" . $withdrawAmount . " was successful.";
                    echo "<br>";
                    echo "New balance: $" . $newNewBalance;
                } else {
                    // Error occurred while updating 'newbal'
                    echo "Error updating 'newbal': " . $stmtUpdateNewBalance->error;
                }

                // Close the prepared statement for updating 'newbal'
                $stmtUpdateNewBalance->close();
            } else {
                // Error occurred while updating 'withdraw'
                echo "Error updating 'withdraw': " . $stmtUpdateWithdraw->error;
            }

            // Close the prepared statement for updating 'withdraw'
            $stmtUpdateWithdraw->close();
        } else {
            // Insufficient balance for withdrawal
            echo "Insufficient balance for withdrawal.";
        }
    } else {
        // Account not found
        echo "The account you wish to withdraw from does not exist. Please check again.";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    // Handle cases where the form hasn't been submitted
    echo "Form not submitted.";
}

// Function to fetch the existing 'newbal' value
function fetchNewBalance($conn, $accountNumber) {
    $sql = "SELECT newbal FROM accounts WHERE accnum = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $accountNumber);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            return $row["newbal"];
        }
    }
    return false;
}
?>