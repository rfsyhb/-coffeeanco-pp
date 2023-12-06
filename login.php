<?php
// Inisialisasi sesi untuk menyimpan informasi login dan lainnya
session_start();

// Menghubungkan dengan file konfigurasi database
require_once 'includes/config.php';

// Mengecek metode permintaan; proses login hanya terjadi pada POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inisialisasi variabel untuk mengecek keberhasilan login
    $check = 0;

    // Membersihkan input username untuk mencegah SQL injection
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    // Mengambil password dari input; perlu dienkripsi sebelum digunakan dalam produksi
    $password = $_POST['password'];

    // Mencari data admin berdasarkan username
    $admin_query = "SELECT * FROM `admin` WHERE username='$username'";
    $admin_data = mysqli_query($connect, $admin_query);
    $admin_row = mysqli_fetch_assoc($admin_data);

    // Mencari data pengunjung/customer berdasarkan username
    $cust_query = "SELECT * FROM pengunjung WHERE cust_username='$username'";
    $cust_data = mysqli_query($connect, $cust_query);
    $cust_row = mysqli_fetch_assoc($cust_data);

    // Verifikasi password admin dan set session jika cocok
    if ($admin_row && password_verify($password, $admin_row['PASSWORD'])) {
        $_SESSION['username'] = $username;
        $_SESSION['status'] = "admin";
        // Mengarahkan ke halaman admin setelah login sukses
        header("location:admin/index.php");
        exit();
    }
    // Verifikasi password customer dan set session jika cocok
    elseif ($cust_row && password_verify($password, $cust_row['cust_password'])) {
        $_SESSION['username'] = $username;
        $_SESSION['cust_id'] = $cust_row['cust_id'];
        $_SESSION['status'] = "customer";

        // Ambil cust_id dari hasil query
        $cust_id = $cust_row['cust_id'];

        // Cek apakah customer sudah memiliki cart
        $cartCheckQuery = "SELECT cart_id FROM cart WHERE cust_id = ?";
        $cartCheckStmt = mysqli_prepare($connect, $cartCheckQuery);
        mysqli_stmt_bind_param($cartCheckStmt, 's', $cust_id);
        mysqli_stmt_execute($cartCheckStmt);
        $result = mysqli_stmt_get_result($cartCheckStmt);
        $cartExists = mysqli_fetch_assoc($result);

        if ($cartExists) {
            // Jika sudah ada, gunakan cart_id yang ada
            $_SESSION['cart_id'] = $cartExists['cart_id'];
        } else {
            // Jika tidak, buat cart baru dan simpan di database
            $cart_id = uniqid('cart_');
            $_SESSION['cart_id'] = $cart_id;
            $_SESSION['cust_id'] = $cust_id;
            $insertCartQuery = "INSERT INTO cart (cart_id, cust_id) VALUES (?, ?)";
            $insertCartStmt = mysqli_prepare($connect, $insertCartQuery);
            mysqli_stmt_bind_param($insertCartStmt, 'ss', $cart_id, $cust_id);
            mysqli_stmt_execute($insertCartStmt);
            mysqli_stmt_close($insertCartStmt);
        }

        // Mengarahkan ke halaman utama setelah login sukses
        header("location:index.php");
        exit();
    } else {
        // Menampilkan pesan error jika username atau password salah
        echo "<script>
            alert('Wrong Input Login!')
        </script>";
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

    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="icon" type="image/png" href="assets/images/coffeeanco.png">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center align-items-center" style="height: 100vh;">
            <!-- Centering the form vertically and horizontally -->
            <div class="login-form">
                <form action="" method="POST">
                    <h3>LOGIN</h3>
                    <div class="form-row d-flex flex-column flex-md-row"> <!-- Flex container for the form row -->
                        <div class="form-group me-md-2 flex-grow-1"> <!-- Container for the input fields -->
                            <input type="text" name="username" class="form-control my-2 py-2" placeholder="Username" />
                            <input type="password" name="password" class="form-control my-2 py-2"
                                placeholder="Password" />
                        </div>
                        <div class="form-action"> <!-- Container for the button -->
                            <button class="btn btn-brown">Login</button>
                        </div>
                        <a href="register.php" class="register-link text-decoration-none">Register</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>