<!DOCTYPE html>
<html>
<head>
    <title>Form Registrasi Admin</title>
</head>
<body>
    <h2>Registrasi Admin</h2>
    <form action="" method="POST">
        <label for="name">Nama:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Daftar">
    </form>
</body>
</html>

<?php
include 'includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Hash password sebelum disimpan di database (disarankan)
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query SQL untuk memasukkan data admin ke dalam tabel Admin
    $sql = "INSERT INTO Admin (NAME, username, PASSWORD) VALUES ('$name', '$username', '$hashed_password')";

    if ($connect->query($sql) === TRUE) {
        echo "Pendaftaran admin berhasil.";
    } else {
        echo "Error: " . $sql . "<br>" . $connect->error;
    }
}
?>
