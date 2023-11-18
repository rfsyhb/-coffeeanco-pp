<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <header>
        <div class="wrapper">
            <h2>Coffee Beans</h2>
            <div class="product-grid">
                <!-- <div class="product-item">
                    <div class="product-image"></div>
                    <p class="product-name">Sample</p>
                    <p class="product-price">IDR 56.999</p>
                </div> -->
                <?php
                // Your MySQL connection code here
                // $conn = new mysqli("servername", "username", "password", "dbname");
                
                // Query the database
                $sql = "SELECT product_name, product_price, product_image FROM products";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='product-item'>";
                        echo "<div class='product-image'><img src='path/to/image/" . $row["product_image"] . "' alt=''></div>";
                        echo "<p class='product-name'>" . $row["product_name"] . "</p>";
                        echo "<p class='product-price'>IDR " . number_format($row["product_price"], 2, ',', '.') . "</p>";
                        echo "</div>";
                    }
                } else {
                    echo "0 results";
                }
                // Close connection
                $conn->close();
                ?>
            </div>
        </div>
    </header>
</body>

</html>