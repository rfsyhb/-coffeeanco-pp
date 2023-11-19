<?php
session_start();

if ($_SESSION['status'] != "customer") {
    header("Location: login.php");
}

include "includes/config.php";
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
    <title>Document</title>
</head>

<body>
    <!-- navbar -->
    <?php include 'includes/navbar.php'; ?>
    <!-- End of the navbar section -->
    <div id="contents">
        <div class="container mt-32">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <!-- Cart items -->
                    <div class="d-flex align-items-center mb-3">
                        <div class="col-4">
                            <img src="assets/images/coffeebagdote.png" alt="Product Image" class="img-fluid">
                        </div>
                        <div class="col-2"></div>
                        <div class="col-4 d-flex flex-column align-items-center">
                            <div class="name-prod">
                                <h5>The Pink Mandarin</h5>
                            </div>
                            <div class="price">
                                <p>Rp 55.900</p>
                            </div>
                            <button class="btn btn-sm btn-outline-secondary">+ 1 -</button>
                            <a href="#" class="btn btn-link btn-sm">Remove</a>
                        </div>
                    </div>
                    <!-- Subtotal -->
                    <div class="d-flex justify-content-end">
                        <div class="subtotal-text">
                            <strong>SUBTOTAL</strong>
                        </div>
                        <div class="subtotal-price">
                            <span>Rp 99.900,00</span>
                        </div>
                    </div>
                    <!-- Checkout button -->
                    <div class="mt-3">
                        <a href="#"
                            class="fs-10 btn btn-primary-dark-outline btn-block d-flex justify-content-end">CHECK
                            OUT</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer id="footers">
        <?php include 'includes/footer.php'; ?>
    </footer>
    <script type="text/javascript" src="assets/js/navbarscript.js"></script>
</body>

</html>