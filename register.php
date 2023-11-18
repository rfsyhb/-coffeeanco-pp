<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div class="wrapper">
        <h1>Daftar User</h1>
        <form action="register.php" method="post">
            <div class="form-group">
                <input type="text" id="name" name="name" placeholder="Name" required>
            </div>
            <div class="form-group">
                <input type="text" id="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" id="password" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="tel" id="phone" name="phone" placeholder="Phone" required>
            </div>
            <div class="form-group">
                <input type="text" id="address" name="address" placeholder="Address" required>
            </div>
            <div class="form-group">
                <input type="text" id="city" name="city" placeholder="City" required>
            </div>
            <div class="form-group">
                <input type="text" id="province" name="province" placeholder="Province" required>
            </div>
            <div class="form-group">
                <input type="text" id="postal code" name="postal code" placeholder="Postal Code" required>
            </div>
            <button type="submit" class="btn">Daftar</button>
        </form>
    </div>
</body>

</html>