<!-- Simpan sebagai process-login.php -->
<?php
// Start session
session_start();

// Dummy check for username and password for demonstration purposes
// In a real-world scenario, you would check against a database
$dummy_username = 'admin';
$dummy_password = 'password123';

// Get username and password from POST request
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Validate credentials
if ($username === $dummy_username && $password === $dummy_password) {
    // Set session variable
    $_SESSION['logged_in'] = true;
    // Redirect to the protected page
    header('Location: protected-page.php');
    exit();
} else {
    // Redirect back to the login page with an error
    header('Location: login7.php?error=invalid_credentials');
    exit();
}
?>