<?php
session_start();

// Memeriksa status pengguna dan mengarahkan ke halaman login jika tidak sesuai
if (!isset($_SESSION['status']) || $_SESSION['status'] != "customer" || !isset($_SESSION['username'])) {
    header("location:login.php");
    exit;
}

require_once "includes/config.php"; // Memasukkan konfigurasi database

// Memproses form jika dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form dan membersihkannya untuk mencegah injection
    $cust_id = mysqli_real_escape_string($connect, $_POST['cust_id']);
    $cust_name = mysqli_real_escape_string($connect, $_POST['cust_name']);
    $cust_email = mysqli_real_escape_string($connect, $_POST['cust_email']);
    $cust_phone = mysqli_real_escape_string($connect, $_POST['cust_phone']);
    $cust_address = mysqli_real_escape_string($connect, $_POST['cust_address']);
    $cust_city = mysqli_real_escape_string($connect, $_POST['cust_city']);
    $cust_province = mysqli_real_escape_string($connect, $_POST['cust_province']);
    $cust_postalcode = mysqli_real_escape_string($connect, $_POST['cust_postalcode']);
    
    // $cust_password = mysqli_real_escape_string($connect, $_POST["cust_password"]);
    // $hashed_password = password_hash($cust_password, PASSWORD_DEFAULT);

    // Validasi format email
    if (!filter_var($cust_email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Format email tidak valid!'); window.history.back();</script>";
        exit;
    }

    // Query update dengan prepared statement untuk keamanan
    $query = "UPDATE pengunjung SET cust_name = ?, cust_email = ?, cust_phone = ?, cust_address = ?, cust_city = ?, cust_province = ?, cust_postalcode = ? WHERE cust_id = ?";
    // $query = "UPDATE pengunjung SET cust_name = ?, cust_email = ?, cust_phone = ?, cust_address = ?, cust_city = ?, cust_province = ?, cust_postalcode = ?, cust_password = ?  WHERE cust_id = ?";
    $statement = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($statement, 'sssssssi', $cust_name, $cust_email, $cust_phone, $cust_address, $cust_city, $cust_province, $cust_postalcode, $cust_id);
    // mysqli_stmt_bind_param($statement, 'ssssssssi', $cust_name, $cust_email, $cust_phone, $cust_address, $cust_city, $cust_province, $cust_postalcode, $hashed_password, $cust_id);
    $result = mysqli_stmt_execute($statement);

    // Memberikan feedback kepada pengguna
    if ($result) {
        echo "<script>alert('Profil pengguna berhasil diperbarui!'); window.location = 'user_profile.php'</script>";
    } else {
        echo "<script>alert('Pembaruan profil pengguna gagal!'); window.location = 'user_profile.php'</script>";
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
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/uprofile.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="assets/images/coffeeanco.png">
    <title>Edit Profile</title>
</head>

<body>
    <?php include 'includes/navbar.php'; ?>

    <div id="contents">
        <div class="container account-page mt-40">
            <div class="row">
                <div class="col-md-8">
                    <h2 class="mb-8">My Account</h2>
                    <div class="user-info fs-sm">
                        <div class="data-pelanggan">
                            <?php
                            $id = $_GET['cust_id'];
                            $query = mysqli_query($connect, "SELECT * FROM pengunjung WHERE cust_id='$id'");
                            $data = mysqli_fetch_array($query);
                            ?>
                            <h4>Update User</h4>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="mb-3">
                                    <input type="hidden" name="cust_id"
                                        value="<?php echo htmlspecialchars($data['cust_id']); ?>">
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="cust_name" id="cust_name"
                                        value="<?php echo $data['cust_name']; ?>" class="form-control" require>
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="cust_email" id="cust_email"
                                        value="<?php echo $data['cust_email']; ?>" class="form-control" require>
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="cust_phone" id="cust_phone"
                                        value="<?php echo $data['cust_phone']; ?>" class="form-control" require>
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="cust_address" id="cust_address"
                                        value="<?php echo $data['cust_address']; ?>" class="form-control" require>
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="cust_city" id="cust_city"
                                        value="<?php echo $data['cust_city']; ?>" class="form-control" require>
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="cust_province" id="cust_province"
                                        value="<?php echo $data['cust_province']; ?>" class="form-control" require>
                                </div>
                                <div class="mb-3">
                                    <input type="text" name="cust_postalcode" id="cust_postalcode"
                                        value="<?php echo $data['cust_postalcode']; ?>" class="form-control" require>
                                </div>
                                <div class="mb-3">
                                    <input type="password" name="cust_password" id="cust_password"
                                        value="" placeholder="Password" class="form-control" require>
                                </div>
                                <div class="action-profile mb-3">
                                    <input type="submit" value="Edit" class="btn-edit" />
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 account-actions">
                    <a class="btn btn-edit fs-8" href="user_profile.php">Back</a>
                    <a class="btn btn-edit fs-8" href="includes/logout.php">Log out</a>
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