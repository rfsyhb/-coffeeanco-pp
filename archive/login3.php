<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style3.css">
</head>
<body>
    <div class="login-container">
        <form action="process-login.php" method="post">
            <div class="login-title">Login</div>
            <div class="form-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="submit" value="LOGIN">
            </div>
        </form>
    </div>
</body>
</html>
