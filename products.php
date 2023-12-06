<?php
// Menggunakan require_once memastikan bahwa file hanya di-include satu kali dan menghasilkan fatal error jika file tidak ditemukan.
require_once "includes/config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/products.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- AOS Animate -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="assets/images/coffeeanco.png">
    <title>Products</title>
</head>

<body>
    <?php include 'includes/navbar.php'; ?>

    <section class="py-12 py-md-24 mt-8">
        <div class="container">
            <h2 class="fs-7 mb-4">Coffee Beans</h2>
            <div class="row g-4">
                <?php
                // Menyederhanakan query dan memastikan efisiensi dengan memilih kolom yang dibutuhkan
                $query = "SELECT prod_id, prod_name, prod_price, prod_image1 FROM produk";
                $result = mysqli_query($connect, $query);

                // Menggunakan variabel untuk mengelola jumlah kolom
                $itemCount = 0;

                // Menggunakan while loop untuk mengambil data
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($itemCount % 4 == 0 && $itemCount != 0) {
                        echo '</div><div class="row g-4">';
                    }
                    ?>
                    <div class="col-12 col-md-6 col-lg-3 mb-8">
                        <a class="d-block text-center product-link"
                            href="detail_product.php?prod_id=<?php echo htmlspecialchars($row['prod_id']); ?>">
                            <!-- Menambahkan alt text untuk meningkatkan aksesibilitas -->
                            <img class="product-image d-block mb-5 w-100 img-fluid border p-2 shadow-sm"
                                src="assets/images/uploaded/<?php echo htmlspecialchars($row['prod_image1']); ?>"
                                alt="Gambar Produk <?php echo htmlspecialchars($row['prod_name']); ?>"
                                style="height: 365px; object-fit: cover;">
                            <div class="order-now fs-9">Order Now</div>
                        </a>
                        <div class="text-center">
                            <h6 class="fs-9 text-dark mt-2">
                                <?php echo htmlspecialchars($row['prod_name']); ?>
                            </h6>
                            <span class="fs-10 text-primary-gradient">
                                IDR
                                <?php echo number_format($row['prod_price'], 2); ?>
                            </span>
                        </div>
                    </div>
                    <?php
                    $itemCount++;
                }
                ?>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script type="text/javascript" src="assets/js/navbarscript.js"></script>
</body>

</html>