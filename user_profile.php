<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <header>
        <!-- navbar -->
    </header>

    <h1>My Account</h1>
    <div class="wrapper">
        <div class="left">
            <?php
            // Your MySQL connection code here
            // Assuming you have a connection variable $conn
            
            // Example of fetching data from the database
            $query = "SELECT cust_name, cust_email, cust_address, cust_city, cust_province, cust_postalcode FROM pengunjung WHERE cust_id = ?";
            // Use prepared statement to prevent SQL injection
            if ($stmt = $conn->prepare($query)) {
                // Assuming you have a session or a variable that stores the customer ID
                $stmt->bind_param("i", $customerID);
                $stmt->execute();
                $stmt->bind_result($cust_name, $cust_email, $cust_address, $cust_city, $cust_province, $cust_postalcode);
                $stmt->fetch();
                echo "<p>" . htmlspecialchars($cust_name) . "</p>";
                echo "<p>" . htmlspecialchars($cust_email) . "</p>";
                echo "<p>" . htmlspecialchars($cust_address) . "</p>";
                echo "<p>" . htmlspecialchars($cust_city) . "</p>";
                echo "<p>" . htmlspecialchars($cust_province) . "</p>";
                echo "<p>" . htmlspecialchars($cust_postalcode) . "</p>";
                $stmt->close();
            }
            ?>
            <a href="edit_account.php" class="btn">Edit</a>
        </div>
        <div class="right">
            <a href="my_orders.php" class="text-link">My Orders</a>
            <a href="logout.php" class="text-link">Log out</a>
        </div>
    </div>
    <footer>
        <!-- footer -->
    </footer>
</body>

</html>