<?php
session_start();

// Memeriksa status pengguna dan mengarahkan ke halaman login jika tidak sesuai
if (!isset($_SESSION['status']) || $_SESSION['status'] != "customer" || !isset($_SESSION['username']) || !isset($_SESSION['cart_id'])) {
    header("location:login.php");
    exit;
}

require_once "includes/config.php";

// Sanitasi dan mendapatkan prod_id dari URL
$prod_id = isset($_GET['prod_id']) ? mysqli_real_escape_string($connect, $_GET['prod_id']) : die('Product ID not specified.');

// Prepared statement untuk mengambil data produk
$stmt = mysqli_prepare($connect, "SELECT * FROM produk WHERE prod_id = ?");
mysqli_stmt_bind_param($stmt, 's', $prod_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$product = mysqli_fetch_assoc($result);

if (!$product) {
    die('Product not found.'); // Jika produk tidak ditemukan
}

// Menghitung stok tersisa
$totalCartQuantityStmt = mysqli_prepare($connect, "SELECT SUM(cart_quantity) as total_quantity FROM cart_details WHERE prod_id = ?");
mysqli_stmt_bind_param($totalCartQuantityStmt, 's', $prod_id);
mysqli_stmt_execute($totalCartQuantityStmt);
$totalCartQuantityResult = mysqli_stmt_get_result($totalCartQuantityStmt);
$totalCartQuantityRow = mysqli_fetch_assoc($totalCartQuantityResult);
$totalCartQuantity = $totalCartQuantityRow ? $totalCartQuantityRow['total_quantity'] : 0;

$stockLeft = $product['prod_stock'] - $totalCartQuantity;

// Query untuk mendapatkan 4 produk dengan harga tertinggi dari jenis yang sama
$upsellStmt = mysqli_prepare($connect, "SELECT * FROM produk WHERE prod_type = ? AND prod_id != ? ORDER BY prod_price DESC LIMIT 4");
mysqli_stmt_bind_param($upsellStmt, 'ss', $product['prod_type'], $prod_id);
mysqli_stmt_execute($upsellStmt);
$upsellResult = mysqli_stmt_get_result($upsellStmt);

// Dapatkan cust_id dan cart_id dari sesi pengguna
$cust_id = $_SESSION['cust_id'];
$cart_id = $_SESSION['cart_id'];

// Proses form jika dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart_quantity = isset($_POST['cart_quantity']) ? (int) $_POST['cart_quantity'] : 0;
    $cart_unit_price = $product['prod_price'];

    // Cek stok yang tersedia
    $availableStock = $stockLeft;

    if ($cart_quantity > $availableStock) {
        $_SESSION['message'] = "Jumlah yang diminta melebihi stok yang tersedia.";
    } else {
        // Cek apakah produk sudah ada di keranjang
        $checkStmt = mysqli_prepare($connect, "SELECT cart_quantity FROM cart_details WHERE cart_id = ? AND prod_id = ?");
        mysqli_stmt_bind_param($checkStmt, 'ss', $cart_id, $prod_id);
        mysqli_stmt_execute($checkStmt);
        $checkResult = mysqli_stmt_get_result($checkStmt);
        $existingProd = mysqli_fetch_assoc($checkResult);

        if ($existingProd) {
            // Jika produk sudah ada, update jumlahnya
            $newQuantity = $existingProd['cart_quantity'] + $cart_quantity;
            $updateStmt = mysqli_prepare($connect, "UPDATE cart_details SET cart_quantity = ? WHERE cart_id = ? AND prod_id = ?");
            mysqli_stmt_bind_param($updateStmt, 'iss', $newQuantity, $cart_id, $prod_id);
            mysqli_stmt_execute($updateStmt);
            mysqli_stmt_close($updateStmt);
        } else {
            // Jika belum ada, tambahkan produk baru ke keranjang
            $cart_detail_id = uniqid("cd_");
            $insertStmt = mysqli_prepare($connect, "INSERT INTO cart_details (cart_detail_id, cart_id, prod_id, cart_quantity, cart_unit_price) VALUES (?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($insertStmt, 'sssii', $cart_detail_id, $cart_id, $prod_id, $cart_quantity, $cart_unit_price);
            mysqli_stmt_execute($insertStmt);
            mysqli_stmt_close($insertStmt);
        }

        // Tampilkan pesan sukses
        $_SESSION['message'] = "Produk berhasil ditambahkan ke keranjang.";
    }

    header("Location: detail_product.php?prod_id=$prod_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/pdetail.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="assets/images/coffeeanco.png">
    <title>Detail Product</title>
</head>

<body>
    <!-- navbar -->
    <?php include 'includes/navbar.php'; ?>

    <!-- Konten utama halaman detail produk -->
    <div class="py-12 py-md-24 align-items-center mt-8">
        <section class="w-100"> <!-- Mengatur lebar penuh untuk section -->
            <section class="container h-100">
                <div class="row h-100 align-items-center justify-content-center">

                    <!-- Menampilkan pesan sukses atau kesalahan jika ada -->
                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['message']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['message']); ?>
                    <?php endif; ?>

                    <!-- Kolom untuk gambar produk -->
                    <div class="produk-img-wrapper col-12 col-lg-6 d-flex justify-content-center">
                        <div class="produk-img-container">
                            <img class="produk-img img-fluid d-block"
                                src="assets/images/uploaded/<?php echo htmlspecialchars($product['prod_image2']); ?>"
                                alt="<?php echo htmlspecialchars($product['prod_name']); ?>">
                        </div>
                    </div>

                    <!-- Kolom untuk detail produk -->
                    <div class="col-12 col-lg-6">
                        <div class="ps-lg-4">
                            <h3 class="fs-5 text-dark mb-4 mt-4">
                                <?php echo htmlspecialchars($product['prod_name']); ?>
                            </h3>
                            <div class="mb-5">
                                <span class="me-2 fs-8 fw-bold text-dark">
                                    IDR
                                    <?php echo number_format($product['prod_price'], 2); ?>
                                </span>
                            </div>
                            <p class="text-muted">
                                <?php echo htmlspecialchars($product['prod_desc']); ?>
                            </p>

                            <!-- Form untuk menambahkan produk ke keranjang -->
                            <form action="" method="post">
                                <div class="mb-8 d-flex justify-content-start align-items-center">
                                    <span class="fw-bold text-dark me-3">Quantity</span>
                                    <div class="d-flex text-secondary border me-3">
                                        <input class="form-control text-center border-0 bg-transparent" type="number"
                                            name="cart_quantity" value="1" min="1"
                                            max="<?php echo $product['prod_stock']; ?>" style="width: 70px;">
                                    </div>
                                    <!-- Menampilkan stok tersisa -->
                                    <div class="stock-info">
                                        <span class="fs-12 text-muted">Stock left:
                                            <?php echo $stockLeft; ?>
                                        </span>
                                    </div>
                                </div>

                                <input type="hidden" name="prod_id" value="<?php echo $product['prod_id']; ?>">
                                <input type="hidden" name="cart_unit_price"
                                    value="<?php echo $product['prod_price']; ?>">
                                <button type="submit" class="btn btn-outline-dark text-dark-white px-8">Add to
                                    Cart</button>
                            </form>

                            <!-- Up-selling Products Row -->
                            <div class="row mt-3">
                                <?php while ($row = mysqli_fetch_assoc($upsellResult)): ?>
                                    <div class="col-6 col-lg-3 mb-3">
                                        <div class="card h-100">
                                            <a class="d-block text-center product-link"
                                                href="detail_product.php?prod_id=<?php echo $row['prod_id']; ?>">
                                                <div class="card-img-top-wrapper">
                                                    <img class="card-img"
                                                        src="assets/images/uploaded/<?php echo $row['prod_image1']; ?>"
                                                        alt="<?php echo $row['prod_name']; ?>">
                                                </div>
                                                <div class="card-body text-center d-flex flex-column">
                                                    <h6 class="card-title not-small-text">
                                                        <?php echo $row['prod_name']; ?>
                                                    </h6>
                                                    <p class="card-text text-center small-text mt-auto">IDR
                                                        <?php echo number_format($row['prod_price'], 2); ?>
                                                    </p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script type="text/javascript" src="assets/js/navbarscript.js"></script>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>