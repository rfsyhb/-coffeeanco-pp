<?php
session_start();

// Cek status pengguna dan arahkan ke halaman login jika tidak sesuai
if (!isset($_SESSION['status']) || $_SESSION['status'] != "customer" || !isset($_SESSION['username'])) {
    header("location:login.php");
    exit;
}

require_once "includes/config.php"; // Menghubungkan ke konfigurasi database
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <title>My Orders</title>
</head>

<body>
    <?php include 'includes/navbar.php'; ?> <!-- Menghubungkan navbar -->

    <div id="contents">
        <div class="container account-page mt-28">
            <div class="row">
                <div class="col-md-2">
                    <h2 class="">My Orders</h2>
                </div>
                <div class="col-md-3">
                    <p>View all your pending, delivered, and returned orders here.</p>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-1">
                    <a class="btn btn-edit fs-8" href="user_profile.php">Back</a>
                </div>
            </div>
            <div class="row mx-5 mt-5">
                <div class="col">
                    <table class="table bg-white rounded shadow-sm  table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Order ID</th>
                                <th scope="col" width="150">Order Date</th>
                                <th scope="col" width="200">Total Amount</th>
                                <th scope="col" width="350">Status</th>
                                <th scope="col" width="200">Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Query untuk mendapatkan data pesanan
                            $cust_id = mysqli_real_escape_string($connect, $_SESSION['cust_id']); // Sanitasi cust_id
                            $datas = mysqli_query($connect, "SELECT * FROM orders WHERE cust_id = '$cust_id'");

                            while ($data = mysqli_fetch_array($datas)) {
                                // Menampilkan data pesanan
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($data['order_id']); ?></td>
                                    <td><?php echo htmlspecialchars($data['order_date']); ?></td>
                                    <td><?php echo htmlspecialchars($data['total_amount']); ?></td>
                                    <td><?php echo htmlspecialchars($data['order_status']); ?></td>
                                    <td>
                                        <a href="https://wa.me/6282154449091?text=Halo!+Saya+ingin+melakukan+pembayaran+untuk+order_id+<?php echo $data['order_id']; ?>"
                                           class="btn-sm btn-primary payment-button" target="_blank">
                                           <span class="fa-brands fa-whatsapp"> <Span>Hubungi Admin</Span>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
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