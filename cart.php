<?php
session_start();

if ($_SESSION['status'] != "customer") {
    header("Location: login.php");
}

include "includes/config.php";

$cart_id = $_SESSION['cart_id'] ?? '';
$cust_id = $_SESSION['cust_id'] ?? '';

$cart_items = [];
$subtotal = 0;

// Query untuk mendapatkan detail produk dalam keranjang
$cartQuery = "SELECT produk.prod_id, produk.prod_name, produk.prod_image1, Cart_Details.cart_quantity, Cart_Details.cart_unit_price
              FROM produk
              JOIN Cart_Details ON produk.prod_id = Cart_Details.prod_id
              WHERE Cart_Details.cart_id = ?";
$cartStmt = mysqli_prepare($connect, $cartQuery);
mysqli_stmt_bind_param($cartStmt, 's', $cart_id);
mysqli_stmt_execute($cartStmt);
$result = mysqli_stmt_get_result($cartStmt);

while ($row = mysqli_fetch_assoc($result)) {
    $cart_items[] = $row;
    $subtotal += $row['cart_quantity'] * $row['cart_unit_price']; // Menghitung subtotal
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $cart_id = $_SESSION['cart_id']; // Dapatkan cart_id dari sesi
    $prod_id = $_POST['prod_id'];
    $cart_quantity = (int) $_POST['cart_quantity'];

    // Query untuk mendapatkan stok produk
    $stockQuery = "SELECT prod_stock FROM produk WHERE prod_id = ?";
    $stockStmt = mysqli_prepare($connect, $stockQuery);
    mysqli_stmt_bind_param($stockStmt, 's', $prod_id);
    mysqli_stmt_execute($stockStmt);
    $stockResult = mysqli_stmt_get_result($stockStmt);
    $stockRow = mysqli_fetch_assoc($stockResult);
    $availableStock = $stockRow['prod_stock'];

    if ($_POST['action'] == 'update_quantity' && isset($_POST['cart_quantity']) && $_POST['cart_quantity'] > 0) {
        if ($cart_quantity > $availableStock) {
            // Jumlah yang diminta melebihi stok yang tersedia
            $_SESSION['message'] = "Jumlah yang diminta melebihi stok yang tersedia.";
        } else {
            // Update database dengan jumlah baru
            $updateQuery = "UPDATE Cart_Details SET cart_quantity = ? WHERE cart_id = ? AND prod_id = ?";
            $stmt = mysqli_prepare($connect, $updateQuery);
            mysqli_stmt_bind_param($stmt, 'iss', $cart_quantity, $cart_id, $prod_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $_SESSION['message'] = "Jumlah berhasil diperbarui.";
        }
    } elseif ($_POST['action'] == 'remove_item') {
        // Remove item logic
        $deleteQuery = "DELETE FROM Cart_Details WHERE cart_id = ? AND prod_id = ?";
        $stmt = mysqli_prepare($connect, $deleteQuery);
        mysqli_stmt_bind_param($stmt, 'ss', $cart_id, $prod_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $_SESSION['message'] = "Item removed successfully.";
    }
    mysqli_stmt_close($stockStmt);

    // Redirect kembali ke halaman cart untuk melihat perubahan
    header("Location: cart.php");
    exit();
}


// Jika tombol checkout diklik
if (isset($_POST['checkout'])) {
    // Mulai transaksi
    mysqli_begin_transaction($connect);

    try {
        $order_id = uniqid("order_");
        $order_date = date("Y-m-d"); // Format tanggal untuk MySQL
        $order_status = 'Belum melakukan pembayaran'; // Setel status awal order
        $total_amount = $subtotal; // This should be calculated as the total amount

        // Buat order baru
        $orderQuery = "INSERT INTO Orders (order_id, order_date, total_amount, cust_id, order_status) VALUES (?, ?, ?, ?, ?)";
        $orderStmt = mysqli_prepare($connect, $orderQuery);
        // Ensure you have the correct number of parameters and types
        mysqli_stmt_bind_param($orderStmt, 'ssdss', $order_id, $order_date, $total_amount, $cust_id, $order_status);
        mysqli_stmt_execute($orderStmt);
        mysqli_stmt_close($orderStmt);

        // Pindahkan setiap item dari Cart_Details ke Order_Details
        foreach ($cart_items as $item) {
            $orderItem_id = uniqid("orderItem_");
            $orderDetailsQuery = "INSERT INTO Order_Details (order_item_id, order_id, prod_id, quantity, unit_price) VALUES (?, ?, ?, ?, ?)";
            $orderDetailsStmt = mysqli_prepare($connect, $orderDetailsQuery);
            mysqli_stmt_bind_param($orderDetailsStmt, 'sssii', $orderItem_id, $order_id, $item['prod_id'], $item['cart_quantity'], $item['cart_unit_price']);
            mysqli_stmt_execute($orderDetailsStmt);
            mysqli_stmt_close($orderDetailsStmt); // Close inside the loop
        }

        // Kosongkan Cart_Details untuk cart_id yang bersangkutan
        $emptyCartQuery = "DELETE FROM Cart_Details WHERE cart_id = ?";
        $emptyCartStmt = mysqli_prepare($connect, $emptyCartQuery);
        mysqli_stmt_bind_param($emptyCartStmt, 's', $cart_id);
        mysqli_stmt_execute($emptyCartStmt);

        // Commit transaksi
        mysqli_commit($connect);

        // Redirect ke halaman konfirmasi atau pembayaran
        header("Location: user_orders.php?cust_id=$cust_id");
        mysqli_stmt_close($emptyCartStmt);
        exit();

    } catch (mysqli_sql_exception $exception) {
        mysqli_rollback($connect);
        throw $exception;
    } finally {
        // Tutup semua statement
        mysqli_stmt_close($orderStmt);
        mysqli_stmt_close($orderDetailsStmt);
        mysqli_stmt_close($emptyCartStmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/cart.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>Cart</title>
</head>

<body>
    <!-- navbar -->
    <?php include 'includes/navbar.php'; ?>
    <!-- End of the navbar section -->

    <div id="contents">
        <div class="container mt-32">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <!-- Tempatkan ini di bagian atas halaman, setelah tag <body> -->
                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php
                            echo htmlspecialchars($_SESSION['message']);
                            unset($_SESSION['message']); // Hapus pesan setelah ditampilkan
                            ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <!-- Cart items -->
                    <?php foreach ($cart_items as $item): ?>
                        <div class="d-flex align-items-center mb-3">
                            <div class="col-6">
                                <!-- prod_image1 -->
                                <img src="assets/images/uploaded/<?php echo $item['prod_image1']; ?>"
                                    alt="<?php echo $item['prod_name']; ?>" class="img-fluid">
                            </div>
                            <div class="col-6 d-flex flex-column align-items-center">
                                <div class="name-prod">
                                    <h5>
                                        <?php echo $item['prod_name']; ?>
                                    </h5>
                                </div>
                                <div class="price">
                                    <p>IDR
                                        <?php echo number_format($item['cart_unit_price'], 2); ?>
                                    </p>
                                </div>
                                <!-- Quantity setting -->
                                <form action="cart.php" method="post">
                                    <div class="d-inline-flex fw-bold text-dark">
                                        <input class="form-control text-center border-1 bg-transparent text-dark"
                                            type="number" name="cart_quantity" value="<?php echo $item['cart_quantity']; ?>"
                                            min="1" style="width: 70px;">
                                    </div>
                                    <input type="hidden" name="action" value="update_quantity">
                                    <input type="hidden" name="prod_id" value="<?php echo $item['prod_id']; ?>">
                                    <button type="submit" class="btn btn-link btn-sm">Update</button>
                                </form>
                                <!-- Button remove from cart -->
                                <form action="cart.php" method="post">
                                    <input type="hidden" name="action" value="remove_item">
                                    <input type="hidden" name="prod_id" value="<?php echo $item['prod_id']; ?>">
                                    <button type="submit" class="btn btn-link btn-sm">Remove</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <!-- Subtotal -->
                    <div class="d-flex justify-content-end">
                        <div class="subtotal-text">
                            <strong>SUBTOTAL&nbsp;</strong>
                        </div>
                        <div class="subtotal-price">
                            <span>Rp
                                <?php echo number_format($subtotal, 2); ?>
                            </span>
                        </div>
                    </div>

                    <?php if (!empty($cart_items)): ?>
                        <!-- Checkout button -->
                        <form action="" method="post">
                            <div class="mt-3 d-flex justify-content-end">
                                <input type="hidden" name="checkout" value="1">
                                <button type="submit" class="fs-10 btn btn-primary-dark-outline btn-block">CHECK
                                    OUT</button>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class="mt-3 d-flex justify-content-end">
                            <p>Keranjang belanja Anda kosong.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>

    <footer id="footers">
        <?php include 'includes/footer.php'; ?>
    </footer>
    <script type="text/javascript" src="assets/js/navbarscript.js"></script>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>