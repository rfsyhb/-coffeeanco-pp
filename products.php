<?php include "includes/config.php"; ?>

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
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous" /> -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- AOS Animate -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <title>Products</title>
</head>

<body>
    <!-- navbar -->
    <?php include 'includes/navbar.php'; ?>
    <!-- End of the navbar section -->

    <section class="py-12 py-md-24 mt-8">
        <div class="container">
            <h2 class="fs-7 mb-4">Coffee Beans</h2> <!-- Title with margin bottom -->
            <div class="row g-4">
                <?php
                $query = "SELECT prod_id, prod_name, prod_price, prod_image1 FROM produk";
                $result = mysqli_query($connect, $query);

                $itemCount = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($itemCount % 4 == 0 && $itemCount != 0) {
                        echo '</div><div class="row g-4">';
                    }
                    ?>
                    <div class="col-12 col-md-6 col-lg-3 mb-8">
                        <a class="d-block text-center product-link"
                            href="detail_product.php?prod_id=<?php echo $row['prod_id']; ?>">
                            <img class="product-image d-block mb-5 w-100 img-fluid border p-2 shadow-sm"
                                src="assets/images/uploaded/<?php echo $row['prod_image1']; ?>" alt=""
                                style="height: 365px; object-fit: cover;">
                            <div class="order-now fs-9">Order Now</div>
                        </a>
                        <div class="text-center">
                            <h6 class="fs-9 text-dark mt-2">
                                <?php echo $row['prod_name']; ?>
                            </h6>
                            <span class="fs-10 text-primary-gradient">IDR
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
    </div>
    </section>
    <?php include 'includes/footer.php'; ?>
    <script type="text/javascript" src="assets/js/navbarscript.js"></script>
</body>

</html>