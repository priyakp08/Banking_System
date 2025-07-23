    <?php
    // Check if the form has been submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $accountNumber = $_POST["modifyAccountNumber"];
        $newAccountName = $_POST["newAccountName"];

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

        // Check if the account exists
        $checkAccountSQL = "SELECT * FROM accounts WHERE accnum = ?";
        $stmt = $conn->prepare($checkAccountSQL);
        $stmt->bind_param("s", $accountNumber);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // Account found, update the account name
            $updateAccountNameSQL = "UPDATE accounts SET accname = ? WHERE accnum = ?";
            $stmt = $conn->prepare($updateAccountNameSQL);
            $stmt->bind_param("ss", $newAccountName, $accountNumber);

            // Execute the SQL statement
            if ($stmt->execute()) {
                // Account name updated successfully
                echo "Account name updated to: " . $newAccountName;
            } else {
                // Error occurred while updating the account name
                echo "Error: " . $stmt->error;
            }
        } else {
            // Account not found
            echo "The account you wish to modify, does not exist. Please check again.";
        }

        // Close the database connection
        $stmt->close();
        $conn->close();
    } else {
        // Handle cases where the form hasn't been submitted
        echo "Form not submitted.";
    }
    ?>
