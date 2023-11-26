<?php
session_start();

if (!isset($_SESSION['status']) || $_SESSION['status'] != "customer" || !isset($_SESSION['username']) || !isset($_SESSION['cart_id'])) {
    header("location:login.php");
}

include "includes/config.php";
// Mendapatkan prod_id dari URL
$prod_id = isset($_GET['prod_id']) ? $_GET['prod_id'] : die('Product ID not specified.');

// Query untuk mengambil data produk
$query = "SELECT * FROM produk WHERE prod_id = '$prod_id'";
$result = mysqli_query($connect, $query);
$product = mysqli_fetch_assoc($result);

// Jika produk tidak ditemukan
if (!$product) {
    die('Product not found.');
}

// mengambil type produk
$typeQuery = "SELECT prod_type FROM produk WHERE prod_id = '$prod_id'";
$typeResult = mysqli_query($connect, $typeQuery);
$typeRow = mysqli_fetch_assoc($typeResult);

if (!$typeRow) {
    die('Product not found.');
}

$current_prod_type = $typeRow['prod_type'];

// Query untuk mendapatkan 4 produk dengan harga tertinggi dari jenis yang sama
$upsellQuery = "SELECT * FROM produk WHERE prod_type = '$current_prod_type' AND prod_id != '$prod_id' ORDER BY prod_price DESC LIMIT 4";
$upsellResult = mysqli_query($connect, $upsellQuery);

// Dapatkan cust_id dari sesi pengguna
$cust_id = $_SESSION['cust_id']; // Pastikan 'cust_id' tersimpan di sesi saat pengguna login
$cart_id = $_SESSION['cart_id'];

// Dapatkan data dari form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart_quantity = $_POST['cart_quantity'] ?? 0;
    $prod_id = $_POST['prod_id'] ?? '';
    $cart_unit_price = $_POST['cart_unit_price'] ?? 0;

    // Cek stok yang tersedia
    $stockQuery = "SELECT prod_stock FROM produk WHERE prod_id = ?";
    $stockStmt = mysqli_prepare($connect, $stockQuery);
    mysqli_stmt_bind_param($stockStmt, 's', $prod_id);
    mysqli_stmt_execute($stockStmt);
    $stockResult = mysqli_stmt_get_result($stockStmt);
    $stockRow = mysqli_fetch_assoc($stockResult);
    $availableStock = $stockRow['prod_stock'];

    // Cek jumlah saat ini di keranjang
    $checkQuery = "SELECT cart_quantity FROM Cart_Details WHERE prod_id = ?";
    $checkStmt = mysqli_prepare($connect, $checkQuery);
    mysqli_stmt_bind_param($checkStmt, 's', $prod_id);
    mysqli_stmt_execute($checkStmt);
    $checkResult = mysqli_stmt_get_result($checkStmt);
    $existingProd = mysqli_fetch_assoc($checkResult);
    $currentQuantityInCart = $existingProd ? $existingProd['cart_quantity'] : 0;

    if ($cart_quantity > $availableStock) {
        // Jumlah yang diminta melebihi stok yang tersedia
        $_SESSION['message'] = "Jumlah yang diminta melebihi stok yang tersedia.";
        header("Location: detail_product.php?prod_id=$prod_id");
        exit();
    }

    // Hitung jumlah total yang diminta
    $totalRequestedQuantity = $currentQuantityInCart + $cart_quantity;

    if ($totalRequestedQuantity > $availableStock) {
        // Jumlah total melebihi stok yang tersedia
        $_SESSION['message'] = "Jumlah total produk melebihi stok yang tersedia.";
        header("Location: detail_product.php?prod_id=$prod_id");
        exit();
    }

    // Cek apakah produk sudah ada di cart_details
    $checkQuery = "SELECT cart_quantity FROM Cart_Details WHERE cart_id = ? AND prod_id = ?";
    $checkStmt = mysqli_prepare($connect, $checkQuery);
    mysqli_stmt_bind_param($checkStmt, 'ss', $cart_id, $prod_id);
    mysqli_stmt_execute($checkStmt);
    $result = mysqli_stmt_get_result($checkStmt);
    $existingProd = mysqli_fetch_assoc($result);

    if ($existingProd) {
        // Jika produk sudah ada, update quantity
        $newQuantity = $existingProd['cart_quantity'] + $cart_quantity;
        $updateQuery = "UPDATE Cart_Details SET cart_quantity = ? WHERE cart_id = ? AND prod_id = ?";
        $updateStmt = mysqli_prepare($connect, $updateQuery);
        mysqli_stmt_bind_param($updateStmt, 'iss', $newQuantity, $cart_id, $prod_id);
        mysqli_stmt_execute($updateStmt);
        mysqli_stmt_close($updateStmt);
    } else {
        // Jika belum ada, insert produk baru
        $cart_detail_id = uniqid("cd_");
        $insertQuery = "INSERT INTO Cart_Details (cart_detail_id, cart_id, prod_id, cart_quantity, cart_unit_price) VALUES (?, ?, ?, ?, ?)";
        $insertStmt = mysqli_prepare($connect, $insertQuery);
        mysqli_stmt_bind_param($insertStmt, 'sssii', $cart_detail_id, $cart_id, $prod_id, $cart_quantity, $cart_unit_price);
        mysqli_stmt_execute($insertStmt);
        mysqli_stmt_close($insertStmt);
    }

    // Tampilkan pesan sukses atau error
    if (mysqli_error($connect)) {
        echo "Error: " . mysqli_error($connect);
    } else {
        $_SESSION['message'] = "Product added to cart successfully.";
        // Redirect ke halaman yang sama untuk menampilkan alert
        header("Location: detail_product.php?prod_id=$prod_id");
        exit();
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
    <link rel="stylesheet" href="assets/css/pdetail.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>Detail Product</title>
</head>

<body>
    <!-- navbar -->
    <?php include 'includes/navbar.php'; ?>
    <!-- End of the navbar section -->

    <div class="py-12 py-md-24 align-items-center mt-8">

        <!-- This will make the div take up full viewport height and center its children vertically -->
        <section class="w-100"> <!-- This will ensure the section takes the full width -->
            <section class="container h-100">
                <div class="row h-100 align-items-center justify-content-center">
                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php
                            echo $_SESSION['message'];
                            unset($_SESSION['message']); // Hapus pesan setelah ditampilkan
                            ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <!-- Image Column -->
                    <div class="produk-img-wrapper col-12 col-lg-6 d-flex justify-content-center">
                        <div class="produk-img-container">
                            <img class="produk-img img-fluid d-block"
                                src="assets/images/uploaded/<?php echo $product['prod_image2']; ?>"
                                alt="<?php echo $product['prod_name']; ?>">
                        </div>
                    </div>
                    <!-- Details Column -->
                    <div class="col-12 col-lg-6">
                        <div class="ps-lg-4">
                            <h3 class="fs-5 text-dark mb-4 mt-4">
                                <?php echo $product['prod_name']; ?>
                            </h3>
                            <div class="mb-5">
                                <span class="me-2 fs-8 fw-bold text-dark">
                                    IDR
                                    <?php echo number_format($product['prod_price'], 2); ?>
                                </span>
                            </div>
                            <div class="desc-item">
                                <p class="text-muted">
                                    <?php echo $product['prod_desc']; ?>
                                </p>
                            </div>
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
                                            <?php echo $product['prod_stock']; ?>
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
    </section>
    </div>
    <?php include 'includes/footer.php'; ?>
    <script type="text/javascript" src="assets/js/navbarscript.js"></script>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>