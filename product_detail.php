<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/pdetail.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>Document</title>
</head>

<body>
    <!-- navbar -->
    <?php include 'includes/navbar.php'; ?>
    <!-- End of the navbar section -->

    <div class="vh-100 d-flex align-items-center bg-light">
        <!-- This will make the div take up full viewport height and center its children vertically -->
        <section class="w-100"> <!-- This will ensure the section takes the full width -->
            <section class="container h-100">
                <div class="row h-100 align-items-center justify-content-center">
                    <!-- Image Column -->
                    <div class="col-12 col-lg-6 d-flex justify-content-center">
                        <img class="img-fluid d-block w-100" src="assets/images/coffeebagdote.png" alt=""
                            style="object-fit: cover;">
                    </div>
                    <!-- Details Column -->
                    <div class="col-12 col-lg-6">
                        <div class="ps-lg-4"> <!-- Adjust padding as needed -->
                            <h3 class="fs-4 text-dark mb-4 mt-6">Arm Bag</h3>
                            <div class="mb-5">
                                <span class="me-2 fs-7 fw-bold text-dark">$29.99 USD</span>
                            </div>
                            <p class="text-muted mb-16">Lorem ipsum dolor sit amet, consectetur adipiscing a elit.
                                Nullam to the dictum aliquet accumsan porta lectus ridiculus in these of mattis.</p>
                            <div class="mb-8">
                                <span class="d-inline-block me-4 fw-bold text-dark">Quantity</span>
                                <div class="d-inline-flex fw-bold text-secondary border">
                                    <input class="form-control text-center border-0 bg-transparent" type="number"
                                        value="1" style="width: 70px;">
                                </div>
                            </div>
                            <a class="btn btn-outline-dark text-dark-white px-8" href="#">Add to Cart</a>
                            <!-- Up-selling Products Row -->
                            <div class="row mt-3">
                                <!-- Up-sell Product 1 -->
                                <div class="col-6 col-lg-3 mb-3">
                                    <div class="card h-100">
                                        <!-- Use a wrapper for the image with padding-top 100% to maintain the aspect ratio -->
                                        <div class="card-img-top-wrapper">
                                            <img class="card-img" src="assets/images/coffeeroaster.png" alt="Product 1">
                                        </div>
                                        <div class="card-body text-center">
                                            <h6 class="card-title">Product 1</h6>
                                            <p class="card-text">$19.99</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Up-sell Product 2 -->
                                <div class="col-6 col-lg-3 mb-3">
                                    <div class="card h-100">
                                        <div class="card-img-top-wrapper">
                                            <img class="card-img" src="assets/images/coffeeroaster.png" alt="Product 2">
                                        </div>
                                        <div class="card-body text-center">
                                            <h6 class="card-title">Product 2</h6>
                                            <p class="card-text">$29.99</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Up-sell Product 3 -->
                                <div class="col-6 col-lg-3 mb-3">
                                    <div class="card h-100">
                                        <div class="card-img-top-wrapper">
                                            <img class="card-img" src="assets/images/coffeeroaster.png" alt="Product 3">
                                        </div>
                                        <div class="card-body text-center">
                                            <h6 class="card-title">Product 3</h6>
                                            <p class="card-text">$39.99</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- Up-sell Product 4 -->
                                <div class="col-6 col-lg-3 mb-3">
                                    <div class="card h-100">
                                        <div class="card-img-top-wrapper">
                                            <img class="card-img" src="assets/images/coffeeroaster.png" alt="Product 2">
                                        </div>
                                        <div class="card-body text-center">
                                            <h6 class="card-title">Product 4</h6>
                                            <p class="card-text">$49.99</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>

    </div>
    </section>
    </div>



    <!-- <header>
        <div class="wrapper">
            <div class="left">
                <img src="assets/images/daridatabase" alt="">
            </div>
            <div class="right">
                <h2>The Pink Mandarin</h2>
                <h4>A refreshing blend of Arabica with hints of citrus.</h4>
                <h4>IDR 58.499</h4>
                <form action="product_detail.php">
                    <label for="quantity">QUANTITY</label>
                    <div class="quantity-input">
                        <button type="button" onclick="decrementValue()">-</button>
                        <input type="text" id="quantity" name="quantity" value="1" readonly>
                        <button type="button" onclick="incrementValue()">+</button>
                    </div>
                    <button type="submit" class="btn">ADD TO CART</button>
                </form>
                <div class="upselling-lists">
                    <div class="upselling-item">
                        <div class="upselling-image"></div>
                        <p class="upselling-name">Sample</p>
                        <p class="upselling-price">IDR 56.999</p>
                    </div>
                    <div class="upselling-item">
                        <div class="upselling-image"></div>
                        <p class="upselling-name">Sample</p>
                        <p class="upselling-price">IDR 56.999</p>
                    </div>
                    
                </div>
            </div>
        </div>
    </header> -->
    <?php include 'includes/footer.php'; ?>
    <script type="text/javascript" src="assets/js/navbarscript.js"></script>
</body>

</html>