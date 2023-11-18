<!-- Simpan sebagai login.php -->
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Page</title>
<style>
    /* Simpan sebagai style.css dan sertakan dalam tag head */
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        background-color: #f5f5f5;
    }
    .login-container {
        border: 1px solid #000;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .login-form {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .form-control {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .form-control input {
        padding: 5px;
        font-size: 16px;
    }
    .login-button {
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
    }
</style>
</head>
<body>
<div class="login-container">
    <h2>Login</h2>
    <form class="login-form" action="process-login.php" method="post">
        <div class="form-control">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-control">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="login-button">LOGIN</button>
    </form>
</div>
</body>
</html>
