<?php
// Memastikan konfigurasi termuat sebelum memproses data
require_once 'includes/config.php';

$error_message = ""; // Inisialisasi variabel untuk pesan error

// Memproses form jika metode request adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Menggunakan mysqli_real_escape_string untuk mencegah SQL Injection
    $name = mysqli_real_escape_string($connect, $_POST["name"]);
    $email = mysqli_real_escape_string($connect, $_POST["email"]);
    $username = mysqli_real_escape_string($connect, $_POST["username"]);
    $password = mysqli_real_escape_string($connect, $_POST["password"]);
    $phone = mysqli_real_escape_string($connect, $_POST["phone"]);
    $address = mysqli_real_escape_string($connect, $_POST["address"]);
    $city = mysqli_real_escape_string($connect, $_POST["city"]);
    $province = mysqli_real_escape_string($connect, $_POST["province"]);
    $postalcode = mysqli_real_escape_string($connect, $_POST["postalcode"]);

    // Validasi format email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Format email tidak valid!'); window.history.back();</script>";
        exit;
    }

    // Cek untuk email
    $query_email = $connect->prepare("SELECT cust_id FROM pengunjung WHERE cust_email = ?");
    $query_email->bind_param("s", $email);
    $query_email->execute();
    $result_email = $query_email->get_result();

    if ($result_email->num_rows > 0) {
        $error_message .= "Email sudah terdaftar. ";
    }

    // Cek untuk nomor telepon
    $query_phone = $connect->prepare("SELECT cust_id FROM pengunjung WHERE cust_phone = ?");
    $query_phone->bind_param("s", $phone);
    $query_phone->execute();
    $result_phone = $query_phone->get_result();

    if ($result_phone->num_rows > 0) {
        $error_message .= "Nomor telepon sudah terdaftar. ";
    }

    // Cek untuk username
    $query_username = $connect->prepare("SELECT cust_id FROM pengunjung WHERE cust_username = ?");
    $query_username->bind_param("s", $username);
    $query_username->execute();
    $result_username = $query_username->get_result();

    if ($result_username->num_rows > 0) {
        $error_message .= "Username sudah terdaftar.";
    }

    if ($error_message == "") {
        // Lanjutkan dengan pendaftaran

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Menyusun query dengan prepared statement untuk keamanan tambahan
        $sql = $connect->prepare("INSERT INTO pengunjung (cust_name, cust_email, cust_username, cust_password, cust_phone, cust_address, cust_city, cust_province, cust_postalcode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $sql->bind_param("sssssssss", $name, $email, $username, $hashed_password, $phone, $address, $city, $province, $postalcode);

        if ($sql->execute()) {
            // Mengalihkan ke halaman index setelah pendaftaran berhasil
            echo "<script>alert('Registrasi berhasil! Silahkan login ulang'); window.location = 'index.php'</script>";
            exit();
        } else {
            echo "Error: " . $sql->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous" />

    <link rel="stylesheet" href="assets/css/register.css">
    <link rel="icon" type="image/png" href="assets/images/coffeeanco.png">
    <title>Regiter Account</title>
</head>

<body>
    <!-- Konten HTML untuk form pendaftaran -->
    <div class="container mb-5">
        <div class="row justify-content-center align-items-center" style="height: 100vh;">
            <div class="register-form">
                <form action="" method="post">
                    <!-- Tampilkan pesan error dengan notifikasi Bootstrap jika ada -->
                    <?php if (!empty($error_message)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>

                    <h3>Daftar User</h3>
                    <div class="form-group">
                        <input type="text" id="name" name="name" class="form-control my-2 py-2" placeholder="Name"
                            required>
                    </div>
                    <div class="form-group">
                        <input type="text" id="email" name="email" class="form-control my-2 py-2" placeholder="Email"
                            required>
                    </div>
                    <div class="form-group">
                        <input type="text" id="username" name="username" class="form-control my-2 py-2"
                            placeholder="Username" required>
                    </div>
                    <div class="form-group">
                        <input type="password" id="password" name="password" class="form-control my-2 py-2"
                            placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" id="phone" name="phone" class="form-control my-2 py-2" placeholder="Phone"
                            required>
                    </div>
                    <div class="form-group">
                        <input type="text" id="address" name="address" class="form-control my-2 py-2"
                            placeholder="Address" required>
                    </div>
                    <div class="form-group">
                        <input type="text" id="city" name="city" class="form-control my-2 py-2" placeholder="City"
                            required>
                    </div>
                    <div class="form-group">
                        <input type="text" id="province" name="province" class="form-control my-2 py-2"
                            placeholder="Province" required>
                    </div>
                    <div class="form-group">
                        <input type="text" id="postalcode" name="postalcode" class="form-control my-2 py-2"
                            placeholder="Postal Code" required>
                    </div>
                    <div class="form-action d-flex justify-content-end mt-3"> <!-- Container for the button -->
                        <button class="btn btn-brown shadow">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>