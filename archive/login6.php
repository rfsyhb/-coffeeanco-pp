<?php
// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assume the user's credentials are valid
    $isValid = true;

    // Check if username and password are set from the form
    if (isset($_POST['username']) && isset($_POST['password'])) {
        
        // Assigning posted values to variables.
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        // Check the credentials (Ini harusnya menghubungkan ke database Anda)
        if ($username == 'expected_username' && $password == 'expected_password') {
            // Authentication successful - Set session
            $_SESSION['user_logged_in'] = true;
            header('Location: welcome.php');
            exit;
        } else {
            // Authentication failed
            $isValid = false;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="style6.css">
</head>
<body>
    <div class="login-container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <h2>Login</h2>
            <?php if (isset($isValid) && !$isValid): ?>
                <p class="error">Invalid username or password!</p>
            <?php endif; ?>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit" name="login">LOGIN</button>
            </div>
        </form>
    </div>
</body>
</html>
