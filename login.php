<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="login-form">
        <form action="path_to_your_authentication_script.php" method="post">
            <div class="form-group">            
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">                
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-action">
                <button type="submit" name="login">LOGIN</button>
            </div>
        </form>
    </div>
</body>

</html>