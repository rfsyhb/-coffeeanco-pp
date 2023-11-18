<?php
// Tempatkan logika pemrosesan login disini jika diperlukan

// Jika sudah login, arahkan ke halaman lain
// if (isset($_SESSION['user_id'])) {
//     header('Location: dashboard.php');
//     exit;
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style4.css"> <!-- Link ke file CSS -->
</head>
<body>

<div class="login-container">
    <form action="process_login.php" method="post"> <!-- action diarahkan ke script PHP yang akan memproses login -->
        <h2>Login</h2>
        <div class="input-group">
            <input type="text" name="username" required placeholder="Username">
            <input type="password" name="password" required placeholder="Password">
        </div>
        <button type="submit" name="login">LOGIN</button>
    </form>
</div>

</body>
</html>
