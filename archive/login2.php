<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Page</title>
<style>
  body {
    font-family: Arial, sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
  }
  .login-container {
    border: 2px solid #000;
    padding: 20px;
    width: 300px;
  }
  .login-container h2 {
    text-align: center;
  }
  .form-field {
    margin-bottom: 10px;
  }
  .form-field label {
    display: block;
    margin-bottom: 5px;
  }
  .form-field input {
    width: calc(100% - 22px);
    padding: 10px;
  }
  .form-field input[type="submit"] {
    width: 100%;
    cursor: pointer;
  }
</style>
</head>
<body>
<div class="login-container">
  <h2>Login</h2>
  <div class="form-field">
    <label for="username">Username</label>
    <input type="text" id="username" name="username">
  </div>
  <div class="form-field">
    <label for="password">Password</label>
    <input type="password" id="password" name="password">
  </div>
  <div class="form-field">
    <input type="submit" value="LOGIN">
  </div>
</div>
</body>
</html>