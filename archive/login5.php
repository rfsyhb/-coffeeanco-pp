<?php
// Kode PHP untuk menangani logika autentikasi bisa ditambahkan di sini

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style5.css"> <!-- Link ke file CSS eksternal -->
</head>
<body>
    <div class="login-container">
        <form action="process_login.php" method="post"> <!-- action harus mengarah ke script PHP yang akan memproses login -->
            <h2>Login</h2>
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <button type="submit" name="login_button">LOGIN</button>
            </div>
        </form>
    </div>
</body>
</html>
