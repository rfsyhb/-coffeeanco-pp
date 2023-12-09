<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Memulai sesi hanya jika sesi belum dimulai
}

require_once 'config.php'; // Menghubungkan ke file konfigurasi database

$total_item = 0; // Inisialisasi $total_item

// Cek apakah ada pengguna yang login
if (isset($_SESSION['username'])) {
    $cust_username = $_SESSION['username'];

    // Query untuk menghitung jumlah item di cart_details
    $query = "SELECT COUNT(*) AS total_item FROM cart_details 
              JOIN cart ON cart.cart_id = cart_details.cart_id 
              WHERE cart.cust_username = ?";
    $stmt = $connect->prepare($query);
    $stmt->bind_param("i", $cust_username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result) {
        $row = $result->fetch_assoc();
        $total_item = $row['total_item'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/navbar.css">
    <style>
        .cart-indicator {
            position: relative;
            top: -10px;
            right: -10px;
            background-color: red;
            color: white;
            font-size: 12px;
            height: 20px;
            width: 20px;
            text-align: center;
            line-height: 20px;
            border-radius: 50%;
        }
    </style>
    <title>Navbar</title>
</head>

<body>

    <header>
        <a href="index.php" class="logo">
            <img src="assets/images/coffeeanco.png" style="height: 43px" alt=""><span>CoffeeanCo</span>
        </a>
        <ul class="navbarun">
            <li>
                <a href="index.php" class="baten">Home</a>
            </li>
            <li>
                <a href="products.php" class="baten">Product</a>
            </li>
            <li>
                <a href="coffee_info.php" class="baten">Learn</a>
            </li>
            <li>
                <a href="user_profile.php" class="baten">Account</a>
            </li>
        </ul>

        <div class="main">

            <a href="cart.php" class="cart">
                <i class="ri-shopping-cart-line"></i>
                <?php if ($total_item > 0): ?>
                    <span class="cart-indicator">
                        <?php echo $total_item; ?>
                    </span>
                <?php endif; ?>
            </a>

            <div class="bx bx-menu" id="menu-icon"></div>
        </div>
    </header>
    <!-- js link -->
    <script type="text/javascript" src="../assets/js/navbarscript.js"></script>
</body>

</html>