<?php
session_start();

// Pengecekan status pengguna dalam session
if (!isset($_SESSION['status']) || $_SESSION['status'] != "customer") {
    header("Location: login.php");
    exit(); // Menghentikan eksekusi lebih lanjut dan mengarahkan ke halaman login
}

include "includes/config.php"; // Memasukkan file konfigurasi untuk koneksi database

$cart_id = $_SESSION['cart_id'] ?? ''; // Mendapatkan cart_id dari session atau default kosong
$cust_id = $_SESSION['cust_id'] ?? ''; // Mendapatkan cust_id dari session atau default kosong

$cart_items = []; // Array untuk menyimpan item dalam keranjang
$subtotal = 0; // Variabel untuk menyimpan subtotal

// Query untuk mendapatkan detail produk dalam keranjang
$cartQuery = "SELECT produk.prod_id, produk.prod_name, produk.prod_image1, cart_details.cart_quantity, cart_details.cart_unit_price
              FROM produk
              JOIN cart_details ON produk.prod_id = cart_details.prod_id
              WHERE cart_details.cart_id = ?";
$cartStmt = mysqli_prepare($connect, $cartQuery);
mysqli_stmt_bind_param($cartStmt, 's', $cart_id);
mysqli_stmt_execute($cartStmt);
$result = mysqli_stmt_get_result($cartStmt);

// Mengumpulkan data produk dan menghitung subtotal
while ($row = mysqli_fetch_assoc($result)) {
    $cart_items[] = $row;
    $subtotal += $row['cart_quantity'] * $row['cart_unit_price']; // Menambahkan ke subtotal
}

// Logika untuk mengelola aksi pada keranjang (update, remove)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $prod_id = $_POST['prod_id']; // ID produk yang akan diperbarui atau dihapus
    $cart_quantity = (int) $_POST['cart_quantity']; // Kuantitas baru dari produk jika di-update

    // Pengecekan stok produk dari database
    $stockQuery = "SELECT prod_stock FROM produk WHERE prod_id = ?";
    $stockStmt = mysqli_prepare($connect, $stockQuery);
    mysqli_stmt_bind_param($stockStmt, 's', $prod_id);
    mysqli_stmt_execute($stockStmt);
    $stockResult = mysqli_stmt_get_result($stockStmt);
    $stockRow = mysqli_fetch_assoc($stockResult);
    $availableStock = $stockRow['prod_stock'];

    
    // Jika aksi adalah update_quantity dan kuantitas valid
    if ($_POST['action'] == 'update_quantity' && $cart_quantity > 0) {
        // Pengecekan apakah kuantitas yang diminta melebihi stok yang tersedia
        if ($cart_quantity > $availableStock) {
            $_SESSION['message'] = "Jumlah yang diminta melebihi stok yang tersedia.";
        } else {
            // Jika stok mencukupi, update kuantitas produk di keranjang
            $updateQuery = "UPDATE cart_details SET cart_quantity = ? WHERE cart_id = ? AND prod_id = ?";
            $stmt = mysqli_prepare($connect, $updateQuery);
            mysqli_stmt_bind_param($stmt, 'iss', $cart_quantity, $cart_id, $prod_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $_SESSION['message'] = "Jumlah berhasil diperbarui.";
        }
    } elseif ($_POST['action'] == 'remove_item') {
        // Jika aksi adalah remove_item, hapus produk dari keranjang
        $deleteQuery = "DELETE FROM cart_details WHERE cart_id = ? AND prod_id = ?";
        $stmt = mysqli_prepare($connect, $deleteQuery);
        mysqli_stmt_bind_param($stmt, 'ss', $cart_id, $prod_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $_SESSION['message'] = "Item berhasil dihapus.";
    }
    mysqli_stmt_close($stockStmt);

    header("Location: cart.php");
    exit();
}

// Logika untuk proses checkout
if (isset($_POST['checkout'])) {
    mysqli_begin_transaction($connect); // Memulai transaksi untuk proses checkout

    try {
        // Membuat order baru dengan status awal dan total harga
        $order_id = uniqid("order_");
        $order_date = date("Y-m-d");
        $order_status = 'Belum melakukan pembayaran';
        $total_amount = $subtotal; // Total harga dihitung dari subtotal keranjang

        // Menyimpan informasi order ke database
        $orderQuery = "INSERT INTO orders (order_id, order_date, total_amount, cust_id, order_status) VALUES (?, ?, ?, ?, ?)";
        $orderStmt = mysqli_prepare($connect, $orderQuery);
        mysqli_stmt_bind_param($orderStmt, 'ssdss', $order_id, $order_date, $total_amount, $cust_id, $order_status);
        mysqli_stmt_execute($orderStmt);
        mysqli_stmt_close($orderStmt);

        // Memindahkan setiap item dari keranjang ke detail order
        foreach ($cart_items as $item) {
            $orderItem_id = uniqid("orderItem_");
            $orderDetailsQuery = "INSERT INTO order_details (order_item_id, order_id, prod_id, quantity, unit_price) VALUES (?, ?, ?, ?, ?)";
            $orderDetailsStmt = mysqli_prepare($connect, $orderDetailsQuery);
            mysqli_stmt_bind_param($orderDetailsStmt, 'sssii', $orderItem_id, $order_id, $item['prod_id'], $item['cart_quantity'], $item['cart_unit_price']);
            mysqli_stmt_execute($orderDetailsStmt);
            mysqli_stmt_close($orderDetailsStmt);
        }

        // Mengosongkan keranjang setelah checkout
        $emptyCartQuery = "DELETE FROM cart_details WHERE cart_id = ?";
        $emptyCartStmt = mysqli_prepare($connect, $emptyCartQuery);
        mysqli_stmt_bind_param($emptyCartStmt, 's', $cart_id);
        mysqli_stmt_execute($emptyCartStmt);
        mysqli_stmt_close($emptyCartStmt);

        mysqli_commit($connect); // Commit transaksi jika semua operasi berhasil

        header("Location: user_orders.php?cust_id=$cust_id"); // Redirect ke halaman konfirmasi
        exit();

    } catch (mysqli_sql_exception $exception) {
        mysqli_rollback($connect); // Rollback transaksi jika terjadi kesalahan
        throw $exception; // Melempar eksepsi untuk penanganan lebih lanjut
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