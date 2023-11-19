<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/uprofile.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>Document</title>
</head>

<body>
    <!-- navbar -->
    <?php include 'includes/navbar.php'; ?>
    <!-- End of the navbar section -->

    <div class="container account-page mt-40">
        <div class="row">
            <div class="col-md-8">
                <h2 class="mb-28">My Account</h2>
                <div class="user-info fs-sm">
                    <div class="data-pelanggan">
                        <h5>Rafi Syihab</h5>
                        <p>rafisyihab3@gmail.com</p>
                        <p>Jl. Bandeng x Gg. X No. x</p>
                        <p>Palangka Raya</p>
                        <p>Kalimantan Tengah</p>
                        <p>73112</p>
                    </div>
                    <div class="action-profile mt-8">
                        <a class="btn-edit" href="#">Edit</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 account-actions">
                <a class="btn btn-edit fs-8" href="#">My Orders</a>
                <a class="btn btn-edit fs-8" href="#">Log out</a>
            </div>
        </div>
    </div>

    
    <?php include 'includes/footer.php'; ?>
    <script type="text/javascript" src="assets/js/navbarscript.js"></script>
</body>

</html>