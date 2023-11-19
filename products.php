<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous" /> -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- AOS Animate -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <title>Document</title>
</head>

<body>
    <!-- navbar -->
    <?php include 'includes/navbar.php'; ?>
    <!-- End of the navbar section -->

    <section class="py-12 py-md-24">
        <div class="container">
            <h2 class="fs-7 mb-4">Coffee Beans</h2> <!-- Title with margin bottom -->
            <div class="row g-4"> <!-- g-* is a gutter class that adds spacing between columns -->
                <!-- prod column -->
                <div class="col-12 col-md-6 col-lg-3 mb-8">
                    <a class="d-block text-center" href="#">
                        <img class="d-block mb-5 w-100 img-fluid border p-2 shadow-sm"
                            src="../vendia/public/vendia-assets/images/item-cards/shirt-products4.png" alt=""
                            style="height: 365px; object-fit: cover;">
                            <h6 class="fs-9 text-dark mt-2">Summer T-Shirt 0492</h6>
                        <span class="fs-10 text-primary-gradient">$99.63</span>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-3 mb-8">
                    <a class="d-block text-center" href="#">
                        <img class="d-block mb-5 w-100 img-fluid border p-2 shadow-sm"
                            src="../vendia/public/vendia-assets/images/item-cards/shirt-products3.png" alt=""
                            style="height: 365px; object-fit: cover;">
                            <h6 class="fs-9 text-dark mt-2">Summer T-Shirt 0492</h6>
                        <span class="fs-10 text-primary-gradient">$99.63</span>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-3 mb-8">
                    <a class="d-block text-center" href="#">
                        <img class="d-block mb-5 w-100 img-fluid border p-2 shadow-sm"
                            src="../vendia/public/vendia-assets/images/item-cards/shirt-products2.png" alt=""
                            style="height: 365px; object-fit: cover;">
                        <h6 class="fs-9 text-dark mt-2">Summer T-Shirt 0492</h6>
                        <span class="fs-10 text-primary-gradient">$99.63</span>
                    </a>
                </div>
                <div class="col-12 col-md-6 col-lg-3 mb-8">
                    <a class="d-block text-center" href="#">
                        <img class="d-block mb-5 w-100 img-fluid border p-2 shadow-sm"
                            src="../vendia/public/vendia-assets/images/item-cards/shirt-products1.png" alt=""
                            style="height: 365px; object-fit: cover;">
                            <h6 class="fs-9 text-dark mt-2">Summer T-Shirt 0492</h6>
                        <span class="fs-10 text-primary-gradient">$99.63</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

</body>

</html>