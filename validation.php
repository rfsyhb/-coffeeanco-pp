<?php
// menghubungkan dengan koneksi
include 'includes/config.php';

if (isset($_POST['submit'])) {
    $check = 0;
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = md5($_POST['password']);
    $admin_data = mysqli_query($connect, "SELECT * FROM admin WHERE username='$username' AND password='$password'");
    $cust_data = mysqli_query($connect, "SELECT * FROM pengunjung WHERE cust_username='$username' AND cust_password='$password'");
    if (mysqli_num_rows($admin_data) === 1) {
        $check = mysqli_num_rows($admin_data);
        $_SESSION['username'] = $username;
        $_SESSION['status'] = "admin";
        header("location:index.php");
        exit();
    } elseif (mysqli_num_rows($cust_data) === 1) {
        $check = mysqli_num_rows($cust_data);
        $_SESSION['username'] = $username;
        $_SESSION['status'] = "customer";
        header("location:index.php");
        exit();
    } else {
        echo "<script>
            alert('Wrong Input Login!')
        </script>";
        header("location:index.php");
        $connect->close();
    }
}
?>