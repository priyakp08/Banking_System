<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;  
            text-align: center; 
            background-image:url('https://us.123rf.com/450wm/ikerjordi/ikerjordi2303/ikerjordi230300099/201054580-elegant-bank-building-entrance-with-soaring-columns-and-intricate-architectural-details-conveying-a.jpg?ver=6'); 
        }

        .button {
            background-color: rgb(240, 248, 255);
            border: none;
            color: white;
            padding: 16px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            transition-duration: 0.4s;
            cursor: pointer;
        }

        .button1 {
            background-color: rgb(240, 248, 255);
            color: black;
        }

        .button1:hover {
            background-color: rgb(47, 79, 79);
            color: white;
        }

        .input-group {
            margin: 10px 0;
        }

        .form-container {
            display: none;
        }

        h1 {
            
            text-align: center;
            color: white;
        }
        #addForm 
        {
            color: white;
        }
        #displayForm {
            color: black;
            background-color: white;
        }
        #deleteForm {
            color: white;
        }
        #searchForm {
            color: white;
        }
        #depositForm {
            color: white;
        }
        #withdrawForm {
            color: white;
        }
        #modifyForm {
            color: white;
        }
        .exit-button 
        {
        color: white; 
        }
        #thankYouMessage {
    color: white;
        }
    

        h3 {
  white-space: nowrap; /* Prevent line breaks */
  overflow: hidden;    /* Hide overflowing content */
  width: 100%;         /* Full width */
  animation: scroll 20s linear infinite;
  color: white;
  font-size: 20px; /* Apply scrolling animation */
}

@keyframes scroll {
  0% {
    transform: translateX(100%); /* Start off-screen to the right */
  }
  100% {
    transform: translateX(-100%); /* Scroll to the left */
  }
}
.larger-font {
            font-size: 5rem; /* You can adjust this value to make it larger */
        }
    </style>
    <script>
        function showForm(formId) {
            var forms = document.querySelectorAll('.form-container');
            forms.forEach(function(form) {
                form.style.display = 'none';
            });
            var form = document.getElementById(formId);
            form.style.display = 'block';
        }
          function showForm(formId) {
            var forms = document.querySelectorAll('.form-container');
            forms.forEach(function(form) {
                form.style.display = 'none';
            });
            var form = document.getElementById(formId);
            form.style.display = 'block';
        }


        function displayThankYou() {
            // Hide all form containers
            var forms = document.querySelectorAll('.form-container');
            forms.forEach(function(form) {
                form.style.display = 'none';
            });
            // Display the "Thank you" message
            var thankYouMessage = document.getElementById('thankYouMessage');
            thankYouMessage.style.display = 'block';
        }
    
    </script>
</head>
<body>
    <h3>Oldest Bank: Banca Monte dei Paschi di Siena, founded in 1472 in Italy, is recognized as the world's oldest surviving bank</h3><br>
    <div class="marquee">
        <h1 class="larger-font">BANKING SYSTEM </h1>
    </div>
    <br><br><br>
    <center>
        <button class="button button1" onclick="showForm('addForm')">1. ADD</button>&emsp;
<button class="button button1" onclick="showForm('displayForm')">2. DISPLAY</button>&emsp;
<button class="button button1" onclick="showForm('deleteForm')">3. DELETE</button>&emsp;
<button class="button button1" onclick="showForm('searchForm')">4. SEARCH</button>&emsp;
<button class="button button1" onclick="showForm('depositForm')">5. DEPOSIT</button>&emsp;
<button class="button button1" onclick="showForm('withdrawForm')">6. WITHDRAW</button>&emsp;
<button class="button button1" onclick="showForm('modifyForm')">7. MODIFY</button>&emsp;
<button class="button button1" onclick="displayThankYou()">8. EXIT</button>
    </center>
    <br><br>
    
    <!-- Add Account Form -->
    <div id="addForm" class="form-container">
        <h2>Add Account</h2>
        <form action="process.php" method="post">
            <div class="input-group">
                <label for="accountNumber">Account Number:</label>
                <input type="text" id="accountNumber" name="accountNumber">
            </div>
            <div class="input-group">
                <label for="accountName">Account Name:</label>
                <input type="text" id="accountName" name="accountName">
            </div>
            <div class="input-group">
                <label for="initialBalance">Initial Balance:</label>
                <input type="number" id="initialBalance" name="initialBalance">
            </div>
            <button class="btn" type="submit">Add</button>
        </form>
    </div>

    <!-- Display Accounts -->
    <center><div id="displayForm" class="form-container">
        <?php
        include("display.php"); // Include PHP script to display accounts
        ?>
    </div></center>

    <!-- Search Account Form -->
    <div id="searchForm" class="form-container">
        <h2>Search Account</h2>
        <form action="search.php" method="post">
    <div class="input-group">
        <label for="searchAccountName">Account Name:</label>
        <input type="text" id="searchAccountName" name="searchAccountName">
    </div>
    <button class="btn" type="submit">Search</button>
</form>
        <!-- Include PHP script for displaying search results -->
    </div>

    <!-- Delete Account Form -->
   <div id="deleteForm" class="form-container">
        <h2>Delete Account</h2>
        <form action="delete.php" method="post">
            <div class="input-group">
                <label for="deleteAccountNumber">Account Number:</label>
                <input type="text" id="deleteAccountNumber" name="deleteAccountNumber">
            </div>
            <button class="btn" type="submit">Delete</button>
        </form>
        <!-- Include PHP script for deleting accounts -->
    </div>



    <!-- Deposit Form -->
   <div id="depositForm" class="form-container">
        <h2>Deposit</h2>
        <form action="deposit.php" method="post">
            <div class="input-group">
                <label for="depositAccountNumber">Account Number:</label>
                <input type="text" id="depositAccountNumber" name="depositAccountNumber">
            </div>
            <div class="input-group">
                <label for="depositAmount">Amount to Deposit:</label>
                <input type="number" id="depositAmount" name="depositAmount">
            </div>
            <button class="btn" type="submit">Deposit</button>
        </form>
        <!-- Include PHP script for depositing into accounts -->
    </div> 


    <!-- Withdraw Form -->
    <div id="withdrawForm" class="form-container">
        <h2>Withdraw</h2>
        <form action="withdraw.php" method="post">
            <div class="input-group">
                <label for="withdrawAccountNumber">Account Number:</label>
                <input type="text" id="withdrawAccountNumber" name="withdrawAccountNumber">
            </div>
            <div class="input-group">
                <label for="withdrawAmount">Amount to Withdraw:</label>
                <input type="number" id="withdrawAmount" name="withdrawAmount">
            </div>
            <button class="btn" type="submit">Withdraw</button>
        </form>
        <!-- Include PHP script for withdrawing from accounts -->

</div>


    <!-- Modify Account Form -->
    <div id="modifyForm" class="form-container">
        <h2>Modify Account</h2>
        <form action="modify.php" method="post">
            <div class="input-group">
                <label for="modifyAccountNumber">Account Number:</label>
                <input type="text" id="modifyAccountNumber" name="modifyAccountNumber">
            </div>
            <div class="input-group">
                <label for="newAccountName">New Name:</label>
                <input type="text" id="newAccountName" name="newAccountName">
            </div>
            <button class="btn" type="submit">Modify</button>
        </form>
        <!-- Secondary Search Account Form -->
<div id="secondarySearchForm" class="form-container">
    <h2>Search Account by Name</h2>
    <form action="secondary_search.php" method="post">
        <div class="input-group">
            <label for="searchAccountName">Account Name:</label>
            <input type="text" id="searchAccountName" name="searchAccountName">
        </div>
        <button class="btn" type="submit">Search</button>
    </form>
    <!-- Include PHP script for displaying search results based on secondary index -->
</div>
        <!-- Include PHP script for modifying accounts -->
    </div>
    <div id="thankYouMessage" class="form-container" style="display: none;">
        <h2>Thank You</h2>
        <p>Thank you for using the banking system. Have a great day!</p>
    </div>
</body>
</html>