<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['cust_id'])) {
    // Redirect to the login page or handle accordingly
    header('Location: login.php');
    exit;
}

// Include your database connection file
include('db_connection.php');

// Set the customer ID from the session
$cust_id = $_SESSION['cust_id'];

// Initialize subtotal
$subtotal = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/uprofile.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>Document</title>
</head>

<body>
    <?php
    // Fetch the user's cart ID
    $cartQuery = "SELECT cart_id FROM cart WHERE cust_id = ?";
    if ($cartStmt = $conn->prepare($cartQuery)) {
        $cartStmt->bind_param("s", $cust_id);
        $cartStmt->execute();
        $cartStmt->bind_result($cart_id);
        $cartStmt->fetch();
        $cartStmt->close();
    }

    // Now, fetch the cart details
    $itemsQuery = "SELECT prod_id, cart_quantity, cart_unit_price FROM cart_details WHERE cart_id = ?";
    if ($itemsStmt = $conn->prepare($itemsQuery)) {
        $itemsStmt->bind_param("s", $cart_id);
        $itemsStmt->execute();
        $result = $itemsStmt->get_result();

        // Fetch each item
        while ($item = $result->fetch_assoc()) {
            // Calculate the item total
            $itemTotal = $item['cart_quantity'] * $item['cart_unit_price'];
            // Add to subtotal
            $subtotal += $itemTotal;

            // Display the cart item
            echo "<div class='cart-item'>";
            // Display product image or placeholder
            echo "<img src='placeholder_image.png' alt='Product Image'>";
            // Assume you have a function getProductDetails to get the product's name by its ID
            $productName = getProductDetails($item['prod_id']);
            echo "<p>" . htmlspecialchars($productName) . "</p>";
            echo "<p>Rp " . number_format($item['cart_unit_price'], 2, ',', '.') . "</p>";
            echo "<p>Quantity: " . $item['cart_quantity'] . "</p>";
            // Add buttons for +1, -1, and remove actions
            echo "<a href='update_cart.php?action=add&prod_id=" . $item['prod_id'] . "'> +1 </a>";
            echo "<a href='update_cart.php?action=remove&prod_id=" . $item['prod_id'] . "'> -1 </a>";
            echo "<a href='update_cart.php?action=delete&prod_id=" . $item['prod_id'] . "'> Remove </a>";
            echo "</div>";
        }
        $itemsStmt->close();
    }

    // Display subtotal
    echo "<div class='subtotal'>";
    echo "<p>SUBTOTAL</p>";
    echo "<p>Rp " . number_format($subtotal, 2, ',', '.') . "</p>";
    echo "</div>";

    // Checkout button
    echo "<div class='checkout'>";
    echo "<a href='checkout.php'>CHECK OUT</a>";
    echo "</div>";

    ?>
    <div class="wrapper">
        <div class="cart-products">
            <div class="cart-product">
                <div class="right">
                    <img src="assets/images/item.png" alt="" />
                </div>
                <div class="left">
                    <h3>Product Name</h3>
                    <p>Price: $25</p>
                    <button type="submit">Remove from cart</button>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>

</html>