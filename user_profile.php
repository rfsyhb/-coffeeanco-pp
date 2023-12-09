<?php
session_start();

// Memeriksa status pengguna dan mengarahkan ke halaman login jika tidak sesuai
if (!isset($_SESSION['status']) || $_SESSION['status'] != "customer" || !isset($_SESSION['username'])) {
    $current_url = urlencode("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    header("Location: login.php?redirect=$current_url");
    exit;
}

require_once "includes/config.php"; // Memasukkan konfigurasi database

$cust_id = ''; // Mendefinisikan variabel cust_id

?>

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
    <link rel="icon" type="image/png" href="assets/images/coffeeanco.png">
    <title>My Profile</title>
</head>

<body>
    <?php include 'includes/navbar.php'; ?> <!-- Menghubungkan navbar -->

    <div id="contents">
        <div class="container account-page mt-28">
            <div class="row">
                <div class="col-md-8">
                    <h2 class="mb-28">My Account</h2>
                    <div class="user-info fs-sm">
                        <?php
                        // Mengambil data pengguna dari database
                        $username = mysqli_real_escape_string($connect, $_SESSION['username']); // Sanitasi username
                        $select_data = mysqli_query($connect, "SELECT * FROM pengunjung WHERE cust_username = '$username'");

                        if (mysqli_num_rows($select_data) > 0) {
                            while ($data = mysqli_fetch_array($select_data)) {
                                $cust_username = $data['cust_username']; // Menyimpan cust_username untuk digunakan di luar loop
                                // Menampilkan data pelanggan
                                ?>
                                <div class="data-pelanggan">
                                    <h5>
                                        <?php echo htmlspecialchars($data['cust_name']); ?>
                                    </h5>
                                    <p>
                                        <?php echo htmlspecialchars($data['cust_email']); ?>
                                    </p>
                                    <p>
                                        <?php echo htmlspecialchars($data['cust_address']); ?>
                                    </p>
                                    <p>
                                        <?php echo htmlspecialchars($data['cust_city']); ?>
                                    </p>
                                    <p>
                                        <?php echo htmlspecialchars($data['cust_province']); ?>
                                    </p>
                                    <p>
                                        <?php echo htmlspecialchars($data['cust_postalcode']); ?>
                                    </p>
                                    <div class="action-profile mt-8">
                                        <a class="btn-edit"
                                            href="user_editprofile.php?cust_username=<?php echo $data['cust_username']; ?>">Edit</a>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<p>No records found.</p>";
                        }
                        ?>
                    </div>
                </div>
                <div class="col-md-4 account-actions">
                    <a class="btn btn-edit fs-8" href="user_orders.php?cust_username=<?php echo $cust_username; ?>">My
                        Orders</a>
                    <a class="btn btn-edit fs-8" href="includes/logout.php">Log out</a>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <script type="text/javascript" src="assets/js/navbarscript.js"></script>
</body>

</html>